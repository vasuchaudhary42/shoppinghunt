import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: 'search',
    templateUrl: 'search.component.html',
    styleUrls: ['search.component.css']
})

export class SearchComponent implements OnInit {
    @Input()  searchList: any[];
    @Output() onSearch: EventEmitter<string> = new EventEmitter<string>();
    @Output() onSearchElementSelect: EventEmitter<any> = new EventEmitter<any>();
    constructor() {
    }

    ngOnInit() {

    }

}