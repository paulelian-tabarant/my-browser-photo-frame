import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Config } from './config';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {

  private selectedAlbumSource = new BehaviorSubject("");
  selectedAlbum = this.selectedAlbumSource.asObservable();

  constructor(private http: HttpClient) { }

  private static handleError(error: any) {
    console.log('Error occured in authentication service.', error);
  }

  albumLogin(albumName: string, albumPassword: string) : Promise<any> {
    const url = `${Config.apiUrl}/albumLogin`;
    /*
    const headers = new HttpHeaders({ 'Content-Type': 'application/json ' });
    const options = { headers: headers, withCredentials: true };
    */

    return this.http.post(url, JSON.stringify({
        'albumName': albumName,
        // temporary : should be sent as hashed (SHA512)
        'albumPassword': albumPassword, 
      }))
      .toPromise()
      .then(() => {
        this.selectedAlbumSource.next(albumName);
      })
      .catch(AuthenticationService.handleError);
  }
}
