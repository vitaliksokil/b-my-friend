import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

// User interface
export interface User {
  name: string;
  email: string;
  password: string;
  password_confirmation: string
}

@Injectable({
  providedIn: 'root'
})

export class AuthService {

  constructor(private http: HttpClient) { }

  // User registration
  register(user: User): Observable<any> {
    return this.http.post('api/auth/register', user);
  }

  // Login
  login(user: User): Observable<any> {
    return this.http.post<any>('api/auth/login', user);
  }

  // Access user profile
  profileUser(): Observable<any> {
    return this.http.post('api/auth/me', {});
  }
}
