import {Component, OnInit} from '@angular/core';
import {slidePanelMenusList} from "./data/slide-panel-menus-list";
import {SlidePanelMenu} from "../core/slide-panel/slide-panel-menu";

@Component({
    selector: 'app-company',
    templateUrl: './company.component.html',
    styleUrls: ['./company.component.css']
})
export class CompanyComponent implements OnInit {
    slidePanelMenusList: SlidePanelMenu[] = [];
    selectedMenu: SlidePanelMenu;
    constructor() {
        this.slidePanelMenusList = slidePanelMenusList;
        if(this.slidePanelMenusList.length){
            this.selectedMenu = this.slidePanelMenusList[0]
        }
    }

    ngOnInit() {
    }
}