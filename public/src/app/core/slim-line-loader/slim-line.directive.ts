
import {AfterViewInit, Directive, ElementRef} from "@angular/core";
@Directive({
    selector: '[slimline]'
})
export class SlimLineDirective{
    constructor(private element: ElementRef){}
}