import {Component, OnInit} from '@angular/core';
import {log} from "util";

@Component({
    selector: 'company-header',
    templateUrl: './header.component.html',
    styleUrls: ['./header.component.css']
})

export class HeaderComponent implements OnInit {
    searchList: any[] = [];
    constructor() {
    }
    ngOnInit() {
    }

    onSearch(search: string) {
        alert(search)
    }

    onSearchElementSelect(searchElement: any) {
        console.log(searchElement);
    }
}