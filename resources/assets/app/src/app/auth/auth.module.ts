import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SignupComponent } from "./pages/signup/signup.component";
import { SigninComponent } from "./pages/signin/signin.component";
import { ForgotPasswordComponent } from "./pages/forgot-password/forgot-password.component";
import { RouterModule, Routes } from "@angular/router";
import { ProfileComponent } from "../user/pages/profile/profile.component";

const authRoutes: Routes = [
  { path: '', component: SigninComponent },
  { path: 'register', component: SignupComponent },
  { path: 'profile', component: ProfileComponent },
  { path: 'forgot-password', component: ForgotPasswordComponent },
];

@NgModule({
  declarations: [SignupComponent, SigninComponent, ForgotPasswordComponent],
  imports: [
    CommonModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forChild(authRoutes),
  ]
})
export class AuthModule { }
