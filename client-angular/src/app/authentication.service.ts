import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Config } from './config';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {

  constructor(private http: HttpClient) { }

  private static handleError(error: HttpErrorResponse) {
		return throwError("Error occured in authentication service. : " + error.error.message);
	}
	
	// Network communication

  albumLogin(albumName: string, albumPassword: string) : Observable<any> {
    const url = `${Config.apiUrl}/albumLogin`;

    return this.http.post(url, JSON.stringify({
        'albumName': albumName,
        // temporary : should be sent as hashed (SHA512)
        'albumPassword': albumPassword, 
      }), { withCredentials: true })
      .pipe(
        catchError(AuthenticationService.handleError)
      );
  }

  userLogin(username: string, password:string) : Observable<any> {
    const url = `${Config.apiUrl}/userLogin`;

    return this.http.post(url, JSON.stringify({
      'username': username,
      'password': password,
		}), { observe: 'response', withCredentials: true })
		.pipe(
			catchError(AuthenticationService.handleError)
		);
  }

  getLoggedUser() : Observable<any> {
    const url = `${Config.apiUrl}/getLoggedUser`

		return this.http.get(url, { withCredentials: true })
			.pipe(
				catchError(AuthenticationService.handleError)
			);
  }
}
