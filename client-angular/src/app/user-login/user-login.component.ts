import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../authentication.service';
import { Router } from '@angular/router';
import { HttpResponse } from '@angular/common/http';

@Component({
  selector: 'app-user-login',
  templateUrl: './user-login.component.html',
  styleUrls: ['./user-login.component.scss']
})
export class UserLoginComponent implements OnInit {

  username: string;
  password: string;

  constructor(
    private authService: AuthenticationService,
    private router: Router) { }

  ngOnInit() {
  }

  sendLogin() {
    // TODO : verify form validity
    let formValid = true;

    if (formValid) {
      this.authService.userLogin(this.username, this.password)
        .then(() => { this.router.navigate(['/userMenu']); })
        .catch(() => { alert('Login failed.'); }); 
    } 
  }
}
