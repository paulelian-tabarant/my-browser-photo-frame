import { Component, OnInit, NgModule } from '@angular/core';

import { AuthenticationService } from '../authentication.service';
import { PhotosManagerService } from '../photos-manager.service';

@Component({
  selector: 'app-album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.less']
})
export class AlbumComponent implements OnInit {

  name: string;
  description: string;

  constructor(
    private authService: AuthenticationService,
    private photosManagerService: PhotosManagerService) { }

  ngOnInit() {
    this.authService.selectedAlbum.subscribe(albumName => {
      this.name = albumName;
    });
  }

}
