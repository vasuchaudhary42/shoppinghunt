import {Injectable} from "@angular/core";

@Injectable()
export class LoaderService {
    message: string;
    show = () => {};
    hide = () => {};
    setMessage = (message: string) => {};
}