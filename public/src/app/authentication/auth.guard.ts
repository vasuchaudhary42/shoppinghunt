import { Injectable } from "@angular/core";
import {
    ActivatedRouteSnapshot,
    CanActivate,
    CanLoad,
    NavigationExtras,
    Route,
    Router, RouterStateSnapshot,
    UrlSegment, UrlTree
} from "@angular/router";
import {Observable, Observer, of} from "rxjs";
import { HttpClient } from "@angular/common/http";

import { AuthService } from "./auth-service";


@Injectable({
    providedIn: "root"
})
export class AuthGuard implements CanLoad, CanActivate{
    isFirstTime:boolean = true;
    constructor(private router: Router, private authService: AuthService,private httpClient: HttpClient){}

    canLoad(route: Route, segments: UrlSegment[]): Observable<boolean> | Promise<boolean> | boolean {
        return new Observable<boolean>((canGuardObserver: Observer<boolean>)=>{
            this.authService.isLoggedIn().subscribe({
                next: (isLoggedIn: boolean)=>{
                    if (!isLoggedIn){
                        if(segments.length && segments[0].path == 'admin' ){
                            this.router.navigate(['/admin/login'])
                        }else {
                            this.router.navigate(['/'])
                        }
                    }
                    canGuardObserver.next(isLoggedIn);
                },
                complete: () => {
                    canGuardObserver.complete();
                }
            });
        });
    }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
        console.log(route);
        console.log(state);
        return true;
    }
}



// let navigationExtras: NavigationExtras = {
//     queryParams: { 'session_id': 123456789 },
//     fragment: 'anchor'
// };
//this.router.navigate(['/login'], navigationExtras);