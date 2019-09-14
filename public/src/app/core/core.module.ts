import {NgModule} from "@angular/core";
import { SlimLineLoaderComponent } from "./slim-line-loader/slim-line-loader.component";
import {SlimLineDirective} from "./slim-line-loader/slim-line.directive";
import {SlimLineLoaderService} from "./slim-line-loader/slim-line-loader.service";
import {LoaderComponent} from "./loader/loader.component";
import {LoaderService} from "./loader/loader.service";
import {SearchComponent} from "./search/search.component";
import {CommonModule} from "@angular/common";
import {SlidePanelComponent} from "./slide-panel/slide-panel.component";

@NgModule({
    declarations: [SlimLineLoaderComponent, SlimLineDirective, LoaderComponent, SearchComponent, SlidePanelComponent],
    exports: [SlimLineLoaderComponent, SlimLineDirective, LoaderComponent, SearchComponent, SlidePanelComponent],
    imports: [
        CommonModule
    ],
    providers: [SlimLineLoaderService, LoaderService]
})
export class CoreModule {}