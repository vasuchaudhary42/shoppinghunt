import {Injectable} from "@angular/core";
import {User} from "./user";

@Injectable()
export class UserProviderService {
    private user: User;

    getUser(): User {
        return this.user;
    }


    setUser(user: User): UserProviderService {
        this.user = user;
        return this;
    }
}
