import { Component, OnInit } from '@angular/core';

import { PhotosManagerService } from '../photos-manager.service';

@Component({
  selector: 'app-slideshow',
  templateUrl: './slideshow.component.html',
  styleUrls: ['./slideshow.component.less']
})
export class SlideshowComponent implements OnInit {

  imageUrlArray: string[] = [];

  constructor(
    private photosManagerService: PhotosManagerService,
  ) { }

  ngOnInit() {
    this.updateContent();

    // Subscribe to the observable notifying that the current album's content has changed
    this.photosManagerService.photosDirChanged
      .subscribe(event => {
        this.updateContent();
      });
  }

  updateContent() {
    this.photosManagerService.getPhotos()
      .subscribe((photosUrls: string[]) => {
        // Add the host prefix to each server image url
        this.imageUrlArray = photosUrls.map( 
          url => "http://localhost/images/" + url
        )
      } )
  }

}
