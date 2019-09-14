import {ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree} from "@angular/router";
import {observable, Observable, Observer, of} from "rxjs";
import {Injectable} from "@angular/core";
import {AuthService} from "./auth-service";
import {el} from "@angular/platform-browser/testing/src/browser_util";
@Injectable({
    providedIn: 'root'
})
export class AnonymousGuard implements CanActivate{
    constructor(private authService: AuthService, private router: Router){}
    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
        return new Observable<boolean>((canActivateObserver: Observer<boolean>) => {
            this.authService.isLoggedIn().subscribe({
                next: (isLoggedIn: boolean)=>{
                    if (isLoggedIn){
                        if(state.url.startsWith('/admin/login')){
                            this.router.navigate(['/admin/dashboard']);
                        }else {
                            this.router.navigate(['/']);
                        }
                    }
                    canActivateObserver.next(!isLoggedIn);
                },
                complete: () => {
                    canActivateObserver.complete();
                }
            });
        })
    }
}