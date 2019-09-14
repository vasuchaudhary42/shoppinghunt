import { Component } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import {Router} from "@angular/router";
import {UserProviderService} from "./shared/user-provider.service";
import {User} from "./shared/user";
import {SlimLineLoaderService} from "./core/slim-line-loader/slim-line-loader.service";
import {LoaderService} from "./core/loader/loader.service";

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css'],
})
export class AppComponent {

    constructor(private http: HttpClient,
                private router: Router,
                private userProvider: UserProviderService,
                private slimLineLoaderService:SlimLineLoaderService,
                private loaderService: LoaderService
    ) {
        userProvider.setUser(JSON.parse(localStorage.getItem('current_user')))
    }
}
