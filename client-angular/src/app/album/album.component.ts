import { Component, OnInit, NgModule } from '@angular/core';

import { AuthenticationService, AlbumInfo } from '../authentication.service';
import { PhotosManagerService } from '../photos-manager.service';

@Component({
  selector: 'app-album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.less']
})
export class AlbumComponent implements OnInit {

  loggedIn: boolean = false;

  name: string;
  description: string;

  constructor(
    private authService: AuthenticationService,
    private photosManagerService: PhotosManagerService) { }

  ngOnInit() {
    this.authService.getAlbumInfo()
      .then((albumInfo : AlbumInfo) => {
        this.name = albumInfo.name;
        this.description = albumInfo.description;
        this.loggedIn = true;
      });
  }

}
