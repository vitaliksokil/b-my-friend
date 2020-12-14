import { Injectable } from '@angular/core';
import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import { TokenService } from "../../token.service";
import {catchError} from "rxjs/operators";
import {AuthStateService} from "../../auth-state.service";
import {Router} from "@angular/router";

@Injectable()
export class ApiHttpInterceptor implements HttpInterceptor {
  constructor(
    private tokenService: TokenService,
    private authState: AuthStateService,
    private router: Router,
  ) { }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    let apiReq = request.clone({ url: `http://morning-beach-19824.herokuapp.com/${request.url}` });

    const accessToken = this.tokenService.getToken();

    apiReq = apiReq.clone({
      setHeaders: {
        Authorization: "Bearer " + accessToken
      }
    });

    return next.handle(apiReq)
      .pipe(
        catchError((error: HttpErrorResponse) => {
          if (error.status === 403) {
            this.authState.setAuthState(false);
            this.tokenService.removeToken();
            this.router.navigate(['login']);
          }

          return throwError(error);
        })
      );
  }
}
