import { Component, OnInit } from '@angular/core';

import { AuthService } from '../../../auth/services/auth.service';
import {Observable, Observer} from "rxjs";
import {DomSanitizer} from "@angular/platform-browser";

// User interface
export interface User {
  name: string;
  email: string;
}

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})

export class ProfileComponent implements OnInit {
  public userProfile: User | undefined;
  public avatar: any;
  public profileLoaded: any;

  constructor(
    public authService: AuthService,
    private sanitizer: DomSanitizer
  ) {
    this.profileLoaded = false;
    this.authService.profileUser().subscribe((data:any) => {
      this.userProfile = data.user;
      this.avatar = this.sanitizer.bypassSecurityTrustResourceUrl(`data:image/png;base64, ${data.user.img}`);
      this.profileLoaded = true;
    }, () => {

    });
  }

  ngOnInit() { }
}
