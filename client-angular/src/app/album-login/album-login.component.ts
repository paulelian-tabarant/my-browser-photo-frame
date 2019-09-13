import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../authentication.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-album-login',
  templateUrl: './album-login.component.html',
  styleUrls: ['./album-login.component.less']
})
export class AlbumLoginComponent implements OnInit {

  albumName: string;
  albumPassword: string;

  constructor(
    private authService: AuthenticationService,
    private router: Router) { }

  ngOnInit() {
  }

  sendLogin() {
    // TODO: Verify form data before sending
    let formValid = true;

    if (formValid) {

      this.authService.albumLogin(this.albumName, this.albumPassword)
        .then(() => {
          this.router.navigate([`/albumView/${this.albumName}`]);
        });
    }
  }

}
