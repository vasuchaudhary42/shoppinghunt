import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from "@angular/common/http";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";
import {UserProviderService} from "../../shared/user-provider.service";

const X_AUTH_TOKEN: string = 'X-AUTH-TOKEN';
const ACCESS_TOKEN: string = 'access_token';
const TOKEN: string        = 'token';
@Injectable()
export class AuthInterceptors implements HttpInterceptor{

    constructor(private userService: UserProviderService){}
    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        let header = {
            ['X-Requested-With']: 'XMLHttpRequest',
        };
        if (this.userService.getUser()){
            Object.assign(header,{
                [X_AUTH_TOKEN]: this.userService.getUser().token
            })
        }
        return next.handle(req.clone({
                        url: `api/${req.url}`,
                        withCredentials: true,
                        setHeaders: header
                    }));
    }
}