import { Injectable } from '@angular/core';
import {migrateLegacyGlobalConfig} from "@angular/cli/utilities/config";

@Injectable({
  providedIn: 'root'
})

export class TokenService {

  private issuer = {
    login: 'http://morning-beach-19824.herokuapp.com/api/auth/login',
    register: 'http://morning-beach-19824.herokuapp.com/api/auth/register'
  }

  constructor() { }

  handleData(token: string){
    localStorage.setItem('auth_token', token);
  }

  getToken(){
    return localStorage.getItem('auth_token');
  }

  // Verify the token
  isValidToken(): boolean {
    return !!this.getToken();
  }

  // User state based on valid token
  isLoggedIn(): boolean {
    return this.isValidToken();
  }

  // Remove token
  removeToken(){
    localStorage.removeItem('auth_token');
  }

}
