import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProfileComponent } from "./pages/profile/profile.component";
import {NgxSkeletonLoaderModule} from "ngx-skeleton-loader";

@NgModule({
  declarations: [ProfileComponent],
    imports: [
        CommonModule,
        NgxSkeletonLoaderModule
    ]
})
export class UserModule { }
