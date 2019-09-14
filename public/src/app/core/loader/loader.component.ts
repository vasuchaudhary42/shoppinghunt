import {Component, OnInit} from '@angular/core';
import {LoaderService} from "./loader.service";

@Component({
    selector: 'loader',
    template:
    `
        <div [class.sh-hide] = "!visible" class="sh-loader-wrapper">
            <div class="sh-loader">
                <img class="sh-loader-img" src="../../../assets/index.shopping-cart-loader-icon.svg">
                <p>{{ message }}</p>
            </div>
        </div>
    `,
    styleUrls: ['./loader.component.css']
})

export class LoaderComponent implements OnInit {
    message: string = "Welcome to ShoppingHunt";
    visible: boolean = false;
    constructor(private loaderService: LoaderService) {
    }

    ngOnInit() {
        this.loaderService.show = this.show.bind(this);
        this.loaderService.hide = this.hide.bind(this);
        this.loaderService.setMessage = this.setMessage.bind(this);
    }
    show() {
        this.visible = true;
    }
    hide() {
        this.visible = false;
    }
    setMessage(message: string) {
        this.message = message;
    }

}