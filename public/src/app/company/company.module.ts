import {NgModule} from "@angular/core";
import {CommonModule} from "@angular/common";


import {CompanyRoutingModule} from "./company-routing.module";
import {DashboardComponent} from "./dashboard/dashboard.component";
import {HeaderComponent} from "./header/header.component";
import {CompanyComponent} from "./company.component";
import {CoreModule} from "../core/core.module";

@NgModule({
    imports: [
        CommonModule,
        CompanyRoutingModule,
        CoreModule
    ],
    declarations: [
        DashboardComponent,
        HeaderComponent,
        CompanyComponent
    ],
    providers: []

})
export class CompanyModule {}