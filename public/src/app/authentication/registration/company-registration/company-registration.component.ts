import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../auth-service";
import {Router} from "@angular/router";
import {ValidationService} from "../../../core/validation.service";
import {HttpClient} from "@angular/common/http";

@Component({
    selector    : 'company-registration',
    templateUrl : './company-registration.component.html'
})
export class CompanyRegistrationComponent implements OnInit{
    constructor(private http: HttpClient, private formBuilder: FormBuilder,private authService: AuthService, private router: Router){}
    password: FormGroup =
        this.formBuilder.group({
                               first:      new FormControl('', [Validators.required, Validators.minLength(8), ValidationService.passwordValidator]),
                               second:     new FormControl('', [Validators.required, Validators.minLength(8), ValidationService.passwordValidator])
        })
    companyForm : FormGroup = this.formBuilder.group({
        name:           new FormControl('', [Validators.required, ValidationService.nameValidation]),
        email:          new FormControl('', [Validators.required, ValidationService.emailValidator]),
        companyName:    new FormControl('', [Validators.required, ValidationService.companyNameValidation]),
        domain:  new FormControl('', [Validators.required, ValidationService.subDomainValidation]),
        password:       this.password
    })
    onSubmit(){
        this.http.post('company/register',JSON.stringify(this.companyForm.value)).subscribe((data:any) =>{
            console.log(data);
        })
    }

    ngOnInit(): void {
    }


    gotoLogin() {
        this.router.navigate(['/company/login'])
    }
}