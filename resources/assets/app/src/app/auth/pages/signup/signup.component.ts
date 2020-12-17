import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { AuthService } from '../../services/auth.service';
import { FormBuilder, FormGroup } from "@angular/forms";

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.scss']
})

export class SignupComponent implements OnInit {
  registerForm: FormGroup;
  errors: any;

  constructor(
    public router: Router,
    public formBuilder: FormBuilder,
    public authService: AuthService
  ) {
    this.registerForm = this.formBuilder.group({
      name: [''],
      email: [''],
      password: ['']
    })
  }

  ngOnInit() { }

  onSubmit() {
    this.authService.register(this.registerForm.value).subscribe(
      result => {
        console.log(result)
      },
      error => {
        this.errors = error.error;
      },
      () => {
        this.registerForm.reset()
        this.router.navigate(['login']);
      }
    )
  }

}
