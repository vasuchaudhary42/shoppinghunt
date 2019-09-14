import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../auth-service";
import {Router} from "@angular/router";
import {ValidationService} from "../../../core/validation.service";
import {UserProviderService} from "../../../shared/user-provider.service";
import {HttpHeaders, HttpResponse} from "@angular/common/http";
import {User} from "../../../shared/user";
import locale = core.locale;

@Component({
    selector:    'company-login',
    templateUrl: './company-login.component.html'
})

export class CompanyLoginComponent implements OnInit{

    constructor(private formBuilder: FormBuilder,
                protected authService: AuthService,
                protected router: Router,
                private userService: UserProviderService){}

    companyForm : FormGroup = this.formBuilder.group({
            email:    new FormControl('', [Validators.required, ValidationService.emailValidator]),
            password: new FormControl('', [Validators.required, Validators.minLength(8), ValidationService.passwordValidator])
        });

    ngOnInit(): void {

    }

    onSubmit() {
        this.authService.routeKey = 'admin';
        this.authService.redirectUrl = '/admin/dashboard';
        this.authService.login(JSON.stringify(this.companyForm.getRawValue())).subscribe((res: HttpResponse<any>) => {
            if(res.status == 200 && res.body.success){
                this.userService.setUser(res.body.user);
                let redirectUrl = '/admin/dashboard';
                if(res.headers.has('referer')){
                    redirectUrl = res.headers.get('referer')
                    redirectUrl = redirectUrl.split('/'+(window['locale'] || 'en'))[1];
                }
                this.router.navigate([redirectUrl]);
            }else {
                console.log(res.body.message)
            }
        })
    }
    gotoRegistration() {
        this.router.navigate(['/admin/registration']);
    }
}