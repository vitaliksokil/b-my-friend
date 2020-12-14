import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Router} from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  constructor(private http: HttpClient, private router: Router) {
  }

  login(email: string, password: string) {
    this.http.post('api/auth/login', {email: email, password: password})
      .subscribe((resp: any) => {
        this.router.navigate(['profile']);

        localStorage.setItem('auth_token', resp.access_toke);
      });
  }

  logout() {
    localStorage.removeItem('token');
  }

  public logIn() {
    return (localStorage.getItem('token') !== null);
  }
}
