import { NgModule }             from "@angular/core";
import { RouterModule, Routes } from "@angular/router";

import { DashboardComponent }    from "./dashboard/dashboard.component";
import {CompanyComponent} from "./company.component";

const appRoutes: Routes = [
    {
        path: '',
        component: CompanyComponent,
        children: [
            {path: 'dashboard',component: DashboardComponent}
        ]
    }
]
@NgModule({
    imports: [
        RouterModule.forChild(appRoutes)
    ],
    exports: [
        RouterModule
    ]
})
export class CompanyRoutingModule {

}