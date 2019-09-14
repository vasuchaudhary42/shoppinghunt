import { HTTP_INTERCEPTORS } from "@angular/common/http";
import { AuthInterceptors }  from './auth-interceptors'

export const    httpInterceptorsProviders = [
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptors, multi: true  }
]