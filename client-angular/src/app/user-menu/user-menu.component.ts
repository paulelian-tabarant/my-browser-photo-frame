import { Component, OnInit } from '@angular/core';
import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';
import { AuthenticationService } from '../authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-menu',
  templateUrl: './user-menu.component.html',
  styleUrls: ['./user-menu.component.scss']
})
export class UserMenuComponent implements OnInit {

  username: string;
  albumsList: AlbumInfo[];

  loggedIn: boolean = false;

  newAlbumTitle: string;
  newAlbumDescription: string;
  newAlbumPassword: string;
  newAlbumPasswordConfirm: string;
  passwordMismatch: boolean = false;
  formSubmitted: boolean = false;

  constructor(
    private photosManagerService: PhotosManagerService,
    private authService: AuthenticationService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.authService.getLoggedUser()
      .then((username: string) => this.username = username)
      .catch(() => {
        this.loggedIn = false;
      });

    this.albumsList = new Array<AlbumInfo>();

    this.photosManagerService.getAlbumsList()
      .then((albumsList: string[]) => {
        albumsList.forEach(album => {
          this.photosManagerService.getAlbumInfo(album)
            .then((albumInfo: AlbumInfo) => {
              this.albumsList.push(albumInfo);
            });
        });
      })
      .then(() => this.loggedIn = true);
  }

  createNewAlbum() {
    this.formSubmitted = true;

    if (this.newAlbumPassword != this.newAlbumPasswordConfirm) {
      this.passwordMismatch = true;
      return;
    }

    this.passwordMismatch = false;

    this.photosManagerService.createAlbum(
      this.newAlbumTitle,
      this.newAlbumDescription,
      this.newAlbumPassword)
      .then(() => {
        $("#newAlbumModal").modal('hide');
        this.router.navigate([encodeURI("/albumEdit/" + this.newAlbumTitle)])
      });
  }
}
