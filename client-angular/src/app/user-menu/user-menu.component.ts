import { Component, OnInit } from '@angular/core';
import { PhotosManagerService } from '../photos-manager.service';
import { AuthenticationService } from '../authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-menu',
  templateUrl: './user-menu.component.html',
  styleUrls: ['./user-menu.component.scss']
})
export class UserMenuComponent implements OnInit {

  username: string;
  albumsList: string[];

  file: any;
  errFile: any;
  errorMsg: any;

  loggedIn: boolean = false;

  constructor(
    private photosManagerService: PhotosManagerService,
    private authService: AuthenticationService,
    private router: Router,
  ) { }

  ngOnInit() {
    this.authService.lastLoggedUser.subscribe((username: string) => {
      this.username = username;
    });

    this.photosManagerService.getAlbumsList()
      .then((albumsList: string[]) => {
        this.albumsList = albumsList;
        this.loggedIn = true;
      });
  }

  onAlbumClick(name: string) {
    // TODO
  }

}
