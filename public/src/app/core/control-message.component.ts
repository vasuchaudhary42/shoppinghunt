import {Component, Input} from "@angular/core";
import {FormControl} from "@angular/forms";
import {ValidationService} from "./validation.service";

@Component({
    selector: 'control-messages',
    template: '<div *ngIf="errorMessage !== null"><label>{{ errorMessage }}</label></div>'
})
export class ControlMessageComponent {
    @Input() control: FormControl;
    constructor(){}
    get errorMessage(): string{
        for (let propertyName in this.control.errors){
            if(this.control.errors.hasOwnProperty(propertyName) && this.control.touched){
                return ValidationService.getValidatorErrorMessage(propertyName, this.control.errors[propertyName])
            }
        }
        return null;
    }
}