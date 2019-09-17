import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';

@Component({
  selector: 'app-album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.scss']
})
export class AlbumComponent implements OnInit {

  loggedIn: boolean = false;

  name: string;
  description: string;

  constructor(
    private photosManagerService: PhotosManagerService,
    private route: ActivatedRoute) { }

  ngOnInit() {
    this.name = this.route.snapshot.paramMap.get('name');

    this.photosManagerService.getAlbumInfo(this.name)
      .then((albumInfo : AlbumInfo) => {
        this.description = albumInfo.description;
        this.loggedIn = true;
      });
  }

}
