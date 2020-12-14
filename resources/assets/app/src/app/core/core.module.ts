import { NgModule } from '@angular/core';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { ApiHttpInterceptor } from './interceptor/http.interceptor';

@NgModule({
  imports: [],
  exports: [],
  providers: [{
    provide: HTTP_INTERCEPTORS,
    useClass: ApiHttpInterceptor,
    multi: true,
  }],
})
export class CoreModule { }
