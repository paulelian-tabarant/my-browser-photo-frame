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

  constructor(
    private photosManagerService: PhotosManagerService,
    private authService: AuthenticationService,
    private router: Router,
  ) { }

  ngOnInit() {
    // TODO: make a request directly to the server
    this.username = this.authService.getLastLoggedUser();

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

  onAlbumClick(name: string) {
    // TODO
  }

}
