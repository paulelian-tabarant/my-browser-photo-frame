import { Component, OnInit, Input } from '@angular/core';

import { PhotosManagerService } from '../photos-manager.service';

@Component({
  selector: 'app-slideshow',
  templateUrl: './slideshow.component.html',
  styleUrls: ['./slideshow.component.scss']
})
export class SlideshowComponent implements OnInit {

  @Input() albumName: string;

  imageUrlArray: string[] = [];
  fullScreen: boolean = false;

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
    this.photosManagerService.getPhotosList(this.albumName)
      .then((photosUrls: string[]) => {
        // Add the host prefix to each server image url
        this.imageUrlArray = photosUrls;
      })
      .catch((error) => console.log);
  }

}
