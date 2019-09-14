import { NgModule }                         from "@angular/core";
import { CommonModule }                     from "@angular/common";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";

import { CompanyLoginComponent } from "./login/company-login/company-login.component";
import {CompanyRegistrationComponent} from "./registration/company-registration/company-registration.component";
import {ControlMessageComponent} from "../core/control-message.component";

@NgModule({
    declarations: [
        CompanyLoginComponent,CompanyRegistrationComponent,ControlMessageComponent
    ],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
    ],
})
export class AuthenticationModule {}