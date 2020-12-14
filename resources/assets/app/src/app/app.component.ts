import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TokenService } from './token.service';
import { AuthStateService } from './auth-state.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})

export class AppComponent implements OnInit {
  isSignedIn = false;

  constructor(
    private authState: AuthStateService,
    public router: Router,
    public token: TokenService,
  ) {
  }

  ngOnInit() {
    this.authState.userAuthState.subscribe(value => {
      this.isSignedIn = value;
    });
  }

  // Signout
  signOut() {
    this.authState.setAuthState(false);
    this.token.removeToken();
    this.router.navigate(['login']);
  }

}
