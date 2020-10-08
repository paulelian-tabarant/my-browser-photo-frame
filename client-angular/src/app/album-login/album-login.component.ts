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
  badAlbumLogin: boolean = false;

  // User login variables
  userName: string;
  userPassword: string;
  loginError: string = "Connexion impossible. Vérifiez vos identifiants.";
	badUserLogin: boolean = false;
	
	// User creation variables
	newUsername: string;
	newPassword: string;
	newPasswordConfirm: string;
	passwordMismatch: boolean = false;
	userCreateError: string = "Impossible de créer un nouvel utilisateur. Vérifiez votre saisie.";
	badUserCreate: boolean = false;

  constructor(
    private authService: AuthenticationService,
    private router: Router) { }

  ngOnInit() {
  }

  sendAlbumLogin() {
    // TODO: Verify form data before sending
    let formValid = true;

    if (formValid) {
      this.authService.albumLogin(this.albumName, this.albumPassword).subscribe(
					() => this.router.navigate([`/albumView/${this.albumName}`]),
					error => this.badAlbumLogin = true
			);
    }
  }

  sendUserLogin() {
    // TODO: Verify form data before sending

		this.authService.userLogin(this.userName, this.userPassword).subscribe(
			success => { 
				// Hides fading divider from window
				$('#userModal').modal('hide'); 

				this.router.navigate(['/userMenu']); 
			},
			error => this.badUserLogin = true
		);
	}
	
	sendUserCreate() {
		// TODO: Verify form data before sending

		if (this.newPassword !== this.newPasswordConfirm) {
			this.passwordMismatch = true;
			return;
		}

		this.passwordMismatch = false;

		this.authService.userCreate(this.newUsername, this.newPassword).subscribe(
			success => {
				$('#newUserModal').modal('hide');
				this.router.navigate(['/userMenu']);
			},
			error => this.badUserCreate = true
		);
	}
}
