import { NgModule }             from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AuthGuard} from "./authentication/auth.guard";
import {CompanyLoginComponent} from "./authentication/login/company-login/company-login.component";
import {CompanyRegistrationComponent} from "./authentication/registration/company-registration/company-registration.component";
import {AnonymousGuard} from "./authentication/anonymous.guard";
import {TestComponent} from "./test.component";

const appRoutes: Routes = [
    {
        path: 'admin/login',
        component: CompanyLoginComponent,
        canActivate: [AnonymousGuard]
    },
    {
        path: 'admin/registration',
        component: CompanyRegistrationComponent,
        canActivate: [AnonymousGuard]
    },
    {
        path: 'admin',
        loadChildren: () => import('./company/company.module').then(module => module.CompanyModule),
        canLoad: [AuthGuard]
    },
    {
        path: '',
        loadChildren: () => import('./customer/customer.module').then(module => module.CustomerModule)
    },
    {
        path: '**',
        component: TestComponent,
    }
];

@NgModule({
    imports: [
        RouterModule.forRoot(
            appRoutes
        )
    ],
    exports: [
        RouterModule
    ]
})
export class AppRoutingModule { }

