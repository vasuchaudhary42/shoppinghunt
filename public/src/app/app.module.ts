import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppComponent } from './app.component';

import '../assets/styles';

import { HttpClientModule } from "@angular/common/http";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";


import {UserProviderService} from "./shared/user-provider.service";
import {httpInterceptorsProviders} from "./security/http-interceptors/http-interceptors";

import {AuthenticationModule} from "./authentication/authentication.module";
import {CoreModule} from "./core/core.module";
import {AppRoutingModule} from "./app-routing.module";

import {TestComponent} from "./test.component";

import {SlimLineDirective} from "./core/slim-line-loader/slim-line.directive";
import {SlimLineLoaderService} from "./core/slim-line-loader/slim-line-loader.service";
import {SlimLineLoaderComponent} from "./core/slim-line-loader/slim-line-loader.component";

@NgModule({
    declarations: [
        AppComponent,TestComponent
    ],
    imports: [
        BrowserModule,
        HttpClientModule,
        AppRoutingModule,
        AuthenticationModule,
        BrowserAnimationsModule,
        CoreModule
    ],
    providers: [
        UserProviderService,
        httpInterceptorsProviders,
    ],
    bootstrap: [
        AppComponent
    ]
})

export class AppModule {}