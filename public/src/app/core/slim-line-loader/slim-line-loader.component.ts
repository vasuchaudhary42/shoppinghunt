import {AfterViewInit, Component, Directive, ElementRef, Input, OnInit, ViewChild} from '@angular/core';
import {SlimLineLoaderService} from "./slim-line-loader.service";
import {SlimLineDirective} from "./slim-line.directive";

const START: string = 'start';
const COMPLETE: string = 'complete';
const EXIT: string = 'exit';

@Component({
    selector: 'slim-line-loader',
    template: `
        <div class="slim-line-loader">
            <div class="slim-line" slimline></div>
        </div>`,
    styleUrls: ['./slim-line-loader-component.component.css'],
})
export class SlimLineLoaderComponent implements AfterViewInit{
    ngAfterViewInit(): void {
        this.slimLineLoaderService.start = this.start.bind(this);
        this.slimLineLoaderService.complete  = this.complete.bind(this);
        this.slimLineLoaderService.exit = this.exit.bind(this);
    }
    @ViewChild(SlimLineDirective, {read: ElementRef}) elementRef : ElementRef;
    constructor(private slimLineLoaderService: SlimLineLoaderService) {
    }

    public complete= () => {
        this.elementRef.nativeElement.classList.remove(START);
        this.elementRef.nativeElement.classList.add(COMPLETE);
    };

    public exit = () => {
        this.elementRef.nativeElement.classList.remove(START);
        this.elementRef.nativeElement.classList.remove(COMPLETE);
    };

    public start = () => {
        console.log('dd',this.elementRef.nativeElement);
        this.elementRef.nativeElement.classList.add(START)
    };
}