import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Config } from './config';

export class AlbumInfo {
  name: string;
  description: string;
}

@Injectable({
  providedIn: 'root'
})
export class PhotosManagerService {

  private photosDir: string = "http://localhost/images/";

  private photosUri: string = "/photosList";
  private albumsUri: string = "/albumsList";
  
  photosDirChanged = new Observable((observer) => {

    const photosDirChangedSource = new EventSource(Config.apiUrl + '/photosDirChanged');

    photosDirChangedSource.onmessage = event => {
      observer.next(event);
    };

  });

  static handleError(error : any) {
    console.log("Error occured in Photos manager service : ");
    console.log(error);
  }

  constructor(private http: HttpClient) { }

  // If previously logged into an album, should return all the names
  // of containing photos.
  getPhotosList(albumName: string) {
    const url = encodeURI(`${Config.apiUrl}/${this.photosUri}?album=${albumName}`);

    return this.http.get(url)
      .toPromise()
      .then((photosUrls: string[]) => {
        return photosUrls.map(url => this.photosDir + url);
      })
      .catch(PhotosManagerService.handleError);
  }

  getAlbumsList() {
    const url = Config.apiUrl + this.albumsUri;
    return this.http.get(url)
      .toPromise()
      .then(albumsList => albumsList as string[])
      .catch(PhotosManagerService.handleError);
  }

  getAlbumInfo(name: string) {
    const url = encodeURI(`${Config.apiUrl}/albumInfo?name=${name}`);

    return this.http.get(url)
      .toPromise()
      .then((albumInfo) => {
        return albumInfo as AlbumInfo;
      })
      .catch(PhotosManagerService.handleError);
  }
}
