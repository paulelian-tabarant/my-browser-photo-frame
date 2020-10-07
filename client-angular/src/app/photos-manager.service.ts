import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators'
import { Config } from './config';

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

  // Photos-related utility functions

  static handleError(error : HttpErrorResponse) {
    return throwError("Error occured in Photos manager service : " + error.error.message);
  }

  static getPhotoUrl(photoName: string) : string {
		let uri = encodeURI(`${Config.apiUrl}/getPhoto?name=${photoName}`); 
		console.log(uri);
	  return uri;
  }

  static getPhotoNameFromUrl(url: string) {
    let filePattern = /name=.+\.jpg/;
    let photoPath = decodeURI(url);
    let fileName = filePattern.exec(photoPath)[0];
    // Suppress parameter part from the string
    fileName = fileName.replace("name=", "");
    return fileName;
  }

  constructor(private http: HttpClient) { }

  // Network communication

  // If previously logged into an album, should return all the names
  // of containing photos.
  getPhotosList(albumName: string) : Observable<any> {
    const url = encodeURI(`${Config.apiUrl}${this.photosUri}?album=${albumName}`);

    return this.http.get(url, { withCredentials: true })
      .pipe(catchError(PhotosManagerService.handleError));
  }

  getAlbumsList() : Observable<any> {
    const url = Config.apiUrl + this.albumsUri;
		return this.http.get(url, { withCredentials: true })
			.pipe(catchError(PhotosManagerService.handleError));
  }

  getAlbumInfo(name: string) : Observable<any> {
    const url = encodeURI(`${Config.apiUrl}/albumInfo?name=${name}`);

    return this.http.get(url, { withCredentials: true })
      .pipe(catchError(PhotosManagerService.handleError));
  }

  deletePhoto(photoUrl: string) : Observable<any> {
    // Remove directory path from name for the request (useless)
    let fileName = PhotosManagerService.getPhotoNameFromUrl(photoUrl);

    const url = `${Config.apiUrl}/deletePhoto`;

    return this.http.post(url, JSON.stringify({
        name: fileName
      }), { withCredentials: true })
      .pipe(catchError(PhotosManagerService.handleError));
  }

  createAlbum(name: string, description: string, password: string) : Observable<any> {
    const url = `${Config.apiUrl}/newAlbum`;

    return this.http.post(url, JSON.stringify({
        name: name,
        description: description,
        password: password,
      }), { withCredentials: true })
      .pipe(catchError(PhotosManagerService.handleError));
  }

  setAlbumCover(albumName: string, photoUrl: string) : Observable<any> {
    const url = `${Config.apiUrl}/setAlbumCover`;
    let photoName = PhotosManagerService.getPhotoNameFromUrl(photoUrl);

    return this.http.post(url, JSON.stringify({
        album: albumName,
        photo: photoName,
      }), { withCredentials: true })
      .pipe(catchError(PhotosManagerService.handleError));
  }
}
