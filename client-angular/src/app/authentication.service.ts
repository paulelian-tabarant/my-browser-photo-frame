import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Config } from './config';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {

  constructor(private http: HttpClient) { }

  private static handleError(error: any) {
    console.log('Error occured in authentication service.', error);
  }

  albumLogin(albumName: string, albumPassword: string) : Promise<any> {
    const url = `${Config.apiUrl}/albumLogin`;

    return this.http.post(url, JSON.stringify({
        'albumName': albumName,
        // temporary : should be sent as hashed (SHA512)
        'albumPassword': albumPassword, 
      }))
      .toPromise()
      .catch((error) => {
        AuthenticationService.handleError(error);
        return Observable.throw(new Error());
      });
  }

  userLogin(username: string, password:string) : Promise<any> {
    const url = `${Config.apiUrl}/userLogin`;

    return this.http.post(url, JSON.stringify({
      'username': username,
      'password': password,
    }), { observe: 'response' })
    .toPromise()
    .catch((error) => {
      AuthenticationService.handleError(error);
      return Observable.throw(new Error());
    });
  }

  getLoggedUser() : Promise<any> {
    const url = `${Config.apiUrl}/getLoggedUser`

    return this.http.get(url)
      .toPromise()
      .catch((error) => {
        AuthenticationService.handleError(error);
        return Observable.throw(new Error());
      });
  }

}
