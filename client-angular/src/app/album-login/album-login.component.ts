import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-album-login',
  templateUrl: './album-login.component.html',
  styleUrls: ['./album-login.component.scss']
})
export class AlbumLoginComponent implements OnInit {

  // Album login variables
  albumName: string;
  albumPassword: string;

  // User login variables
  userName: string;
  userPassword: string;

  loginError: string = "Connexion impossible. Vérifiez vos identifiants.";
  badAlbumLogin: boolean = false;
  badUserLogin: boolean = false;

  constructor(
    private authService: AuthenticationService,
    private router: Router) { }

  ngOnInit() {
  }

  sendAlbumLogin() {
    // TODO: Verify form data before sending
    let formValid = true;

    if (formValid) {

      this.authService.albumLogin(this.albumName, this.albumPassword)
        .then(() => this.router.navigate([`/albumView/${this.albumName}`]))
        .catch(() => this.badAlbumLogin = true);
    }
  }

  sendUserLogin() {
    // TODO: Verify form data before sending
    let formValid = true;

    if (formValid) {
      this.authService.userLogin(this.userName, this.userPassword)
        .then(() => { 
          // Hides fading divider from window
          $('#userModal').modal('hide'); 

          this.router.navigate(['/userMenu']); 
        })
        .catch(() => this.badUserLogin = true);
    }
  }

}
