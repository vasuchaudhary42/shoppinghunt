import {Component} from "@angular/core";
import {Router} from "@angular/router";

@Component({
    selector: '',
    templateUrl: './home.component.html'
})
export class HomeComponent {
    constructor(private router: Router){}
    onClick() {
        this.router.navigate(['./cart'])
    }
}