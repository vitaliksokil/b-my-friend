import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { SignupComponent } from "./signup/signup.component";
import {SigninComponent} from "./signin/signin.component";

@NgModule({
  declarations: [SignupComponent, SigninComponent],
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
  ]
})
export class AuthModule { }
