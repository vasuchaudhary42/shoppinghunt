import {Component} from "@angular/core";
import {Router} from "@angular/router";

@Component({
    selector: 'app-customer-cart',
    templateUrl: 'cart.component.html'
})
export class CartComponent {
    constructor(private router: Router){}
    onClick() {
        this.router.navigate(['./'])
    }

    onRederect() {
        this.router.navigate(['../company/dashboard'])
    }
}