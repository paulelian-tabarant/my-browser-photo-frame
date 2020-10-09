import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-menu',
  templateUrl: './user-menu.component.html',
  styleUrls: ['./user-menu.component.scss']
})
export class UserMenuComponent implements OnInit {

  username: string;
	loggedIn: boolean = true;
	
	selectedAlbumName: string = "";
	lastSelectedAlbumName: string = "";

  constructor(
		private authService: AuthenticationService,
		private router: Router
  ) { }

  ngOnInit() {
    this.authService.getLoggedUser().subscribe(
			(username: string) => this.username = username,
			(error) => this.loggedIn = false
		); 
	}

	onAlbumEdit(name: string) {
		this.selectedAlbumName = name;
		this.lastSelectedAlbumName = this.selectedAlbumName;
	}

	onBack() {
		this.selectedAlbumName = "";
	}

	onLogout() {
		this.authService.userLogout().subscribe(
			// TODO: implement logout in authentication service and server
			() => this.router.navigate([''])
		);
	}
}