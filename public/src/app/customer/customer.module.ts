import {NgModule} from "@angular/core";
import {CustomerComponent} from "./customer.component";
import {CustomerRoutingModule} from "./customer-routing.module";
import {HomeComponent} from "./home/home.component";
import {CartComponent} from "./cart/cart.component";

@NgModule({
    declarations:[CustomerComponent,HomeComponent,CartComponent],
    imports: [CustomerRoutingModule],
    exports: [],
    providers: []
})
export class CustomerModule {

}