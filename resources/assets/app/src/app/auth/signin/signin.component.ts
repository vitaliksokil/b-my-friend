import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../auth.service';
import { FormBuilder, FormGroup } from "@angular/forms";
import { TokenService } from '../../token.service';
import { AuthStateService } from '../../auth-state.service';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss']
})

export class SigninComponent implements OnInit {
  loginForm: FormGroup;
  errors: any;

  constructor(
    public router: Router,
    public formBuilder: FormBuilder,
    public authService: AuthService,
    private token: TokenService,
    private authState: AuthStateService,
  ) {
    this.loginForm = this.formBuilder.group({
      email: [],
      password: []
    })
  }

  ngOnInit() { }

  onSubmit() {
    this.authService.login(this.loginForm.value).subscribe(
      result => {
        this.responseHandler(result);
      },
      error => {
        this.errors = error.error;
      },() => {
        this.authState.setAuthState(true);
        this.loginForm.reset()
        this.router.navigate(['profile']);
      }
    );
  }

  // Handle response
  responseHandler(data: any){
    this.token.handleData(data.access_token);
  }

}
