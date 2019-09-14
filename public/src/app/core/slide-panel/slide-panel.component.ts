import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {SlidePanelMenu} from "./slide-panel-menu";

@Component({
    selector: 'slide-panel',
    templateUrl: 'slide-panel.component.html',
    styleUrls: ['slide-panel.component.css']
})
export class SlidePanelComponent implements OnInit {
    @Input() slidePanelMenus: SlidePanelMenu[] = [];
    @Input() selectedMenu: SlidePanelMenu;
    @Output() onMenuSelect : EventEmitter<SlidePanelMenu> = new EventEmitter<SlidePanelMenu>();
    constructor() {
    }

    ngOnInit() {
    }
}
