import { Injectable } from "@angular/core";
import {HttpClient, HttpResponse} from "@angular/common/http";
import {map} from "rxjs/operators";
import {observable, Observable, Observer, of, pipe, Subject} from "rxjs";
import {UserProviderService} from "../shared/user-provider.service";
import {User} from "../shared/user";
import {Router, UrlSegment} from "@angular/router";
import {API} from "../shared/api";

@Injectable({
    providedIn: "root"
})
export class AuthService {
    redirectUrl: string = '';
    routeKey: string = '';
    constructor(private httpService: HttpClient,private userService: UserProviderService,private router: Router){}

    login(param: any) {
        return this.httpService.post(`${this.routeKey}/login`,param,{observe: "response"});
    }

    logout() : void{

    }

    isLoggedIn(): Observable<boolean>{
        return new Observable<boolean>((observer: Observer<boolean>)=>{
            this.httpService.get(API.ADMIN.ACCOUNT).subscribe((data: User)=>{
                if(data){
                    this.userService.setUser(data);
                     observer.next(true);
                }else {
                    observer.next(false);
                }
                    observer.complete();
            },error => {
                observer.next(false);
                observer.complete();
            });
        });
    }
}