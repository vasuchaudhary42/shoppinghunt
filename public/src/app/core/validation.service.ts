import { FormControl } from "@angular/forms";


export class ValidationService {

    static getValidatorErrorMessage(validatorName: string, validatorValue?: any) {
        let config = {
            required: 'Required',
            inValidName: 'Invalid Name',
            inValidDomain: 'Invalid Company Domain ',
            invalidEmailAddress: 'Invalid Email Address',
            invalidPassword: 'Invalid password. Password must be at least 8 characters long, and contain a number.',
            minlength: `Minimum length must be ${validatorValue.requiredLength}`
        };
        return config[validatorName];
    }
    static companyNameValidation(control: FormControl){
        if(control.value.match(/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/)){
            return null
        }else{
            return { inValidCompanyName: true }
        }
        return null;
    }
    static nameValidation(control: FormControl){
        if(control.value.match(/^[a-zA-Z\s]+$/)){
            return null;
        }else{
            return { inValidName: true }
        }
        return null;
    }
    static subDomainValidation(control: FormControl) {
        if(control.value.match(/^[A-Za-z0-9](?:[A-Za-z0-9\-]{0,61}[A-Za-z0-9])?$/)){
            return null;
        }else {
            return { inValidDomain: true }
        }
    }

    static emailValidator(control: FormControl) {
        // RFC 2822 compliant regex
        if (control.value.match(/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/)) {
            return null;
        } else {
            return { 'invalidEmailAddress': true };
        }
    }

    static passwordValidator(control: FormControl) {
        if (control.value.match(/^(?=.*[0-9])[a-zA-Z0-9!@#$%^&*]{8,15}$/)) {
            return null;
        } else {
            return { 'invalidPassword': true };
        }
    }
}