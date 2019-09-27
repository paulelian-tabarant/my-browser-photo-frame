import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, VirtualTimeScheduler } from 'rxjs';
import { Config } from './config';
import { decode } from 'punycode';

export class AlbumInfo {
  name: string;
  description: string;
  cover: string;
}

@Injectable({
  providedIn: 'root'
})
export class PhotosManagerService {

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
    const url = encodeURI(`${Config.apiUrl}${this.photosUri}?album=${albumName}`);

    return this.http.get(url)
      .toPromise()
      .then((photosUrls: string[]) => {
        return photosUrls.map(url => 
          encodeURI(`${Config.apiUrl}/getPhoto?name=${url}`));
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
      .then((albumInfo: AlbumInfo) => {
        // Convert relative to absolute path
        albumInfo.cover = `${Config.apiUrl}/getPhoto?name=${albumInfo.cover}`;
        return albumInfo;
      })
      .catch(PhotosManagerService.handleError);
  }

  getPhotoNameFromUrl(url: string) {
    let filePattern = /name=.+\.jpg/;
    let photoPath = decodeURI(url);
    let fileName = filePattern.exec(photoPath)[0];
    // Suppress parameter part from the string
    fileName = fileName.replace("name=", "");
    return fileName;
  }

  deletePhoto(photoUrl: string) {
    // Remove directory path from name for the request (useless)
    let fileName = this.getPhotoNameFromUrl(photoUrl);

    const url = `${Config.apiUrl}/deletePhoto`;

    return this.http.post(url, JSON.stringify({
        name: fileName
      }))
      .toPromise()
      .catch(PhotosManagerService.handleError);
  }

  createAlbum(name: string, description: string, password: string) {
    const url = `${Config.apiUrl}/newAlbum`;

    return this.http.post(url, JSON.stringify({
        name: name,
        description: description,
        password: password,
      }))
      .toPromise()
      .catch(PhotosManagerService.handleError);
  }

  setAlbumCover(albumName: string, photoUrl: string) {
    const url = `${Config.apiUrl}/setAlbumCover`;
    let photoName = this.getPhotoNameFromUrl(photoUrl);

    return this.http.post(url, JSON.stringify({
        album: albumName,
        photo: photoName,
      }))
      .toPromise()
      .catch(PhotosManagerService.handleError);
  }
}
