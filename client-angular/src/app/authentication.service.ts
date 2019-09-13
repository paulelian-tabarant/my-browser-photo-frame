import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Config } from './config';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {

  private lastLoggedUserSrc = new BehaviorSubject("");
  lastLoggedUser = this.lastLoggedUserSrc.asObservable();

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
      .catch(AuthenticationService.handleError);
  }

  userLogin(username: string, password:string) : Promise<any> {
    const url = `${Config.apiUrl}/userLogin`;

    return this.http.post(url, JSON.stringify({
      'username': username,
      'password': password,
    }), { observe: 'response' })
    .toPromise()
    .then(() => { this.lastLoggedUserSrc.next(username); })
    .catch((error) => {
      AuthenticationService.handleError;
      return Observable.throw(new Error());
    });
  }

}
