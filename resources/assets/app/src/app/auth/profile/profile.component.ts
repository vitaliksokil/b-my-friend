import { Component, OnInit } from '@angular/core';

import { AuthService } from '../../auth.service';

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

  constructor(
    public authService: AuthService
  ) {
    this.authService.profileUser().subscribe((data:any) => {
      this.userProfile = data.user;
    }, () => {

    });
  }

  ngOnInit() { }
}
