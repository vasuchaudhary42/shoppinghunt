import {Component, OnInit} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {User} from "../../shared/user";


@Component({
    selector: 'company-dashboard',
    templateUrl: './dashboard.component.html'
})
export class DashboardComponent implements OnInit{
    constructor(private httpClient: HttpClient){}
    ngOnInit(): void {
        // this.httpClient.get('company/detail').subscribe((data: any)=> {
        //     console.log(data);
        // });
    }

    getUserDetail() {
        this.httpClient.get('company/detail').subscribe((data: any)=>{
            console.log(data.user);
        });
    }
}