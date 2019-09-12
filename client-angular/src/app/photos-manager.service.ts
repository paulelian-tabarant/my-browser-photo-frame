import { Injectable, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { EventEmitter } from 'events';
import { Observable } from 'rxjs';
import { Config } from './config';

@Injectable({
  providedIn: 'root'
})
export class PhotosManagerService {

  photosUri: string = "/photos";
  
  photosDirChanged = new Observable((observer) => {

    const photosDirChangedSource = new EventSource(Config.apiUrl + '/photosDirChanged');

    photosDirChangedSource.onmessage = event => {
      observer.next(event);
    };

  });

  constructor(private http: HttpClient) { }

  // If previously logged into an album, should return all the names
  // of containing photos.
  getPhotos() {
    return this.http.get(Config.apiUrl + this.photosUri);
  }

  getPhotosDirChangedEvent() {
  }
}
