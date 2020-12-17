import {Component, OnInit} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup} from "@angular/forms";

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.scss']
})
export class ForgotPasswordComponent implements OnInit {
  resetForm: FormGroup;
  errors: any;
  message: any;

  constructor(private http: HttpClient,  private router: Router,  private formBuilder: FormBuilder) {
    this.resetForm = this.formBuilder.group({
      email: [],
    })
  }

  ngOnInit() {}

  resetHandler() {
    this.http.post('/api/auth/reset-password', this.resetForm.value).subscribe(
      // @ts-ignore
      ({ message }) => {
        this.message = message;
      },
      error => {
        this.errors = error.error;
        this.message = null
      },
      () => {
        this.resetForm.reset()
      }
    );
  }

  goToLogin() {
    this.router.navigate(['login'])
  }
}
