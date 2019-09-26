import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Injectable } from '@angular/core';

export interface ConfigFileObject {
    hostIpAddr: string;
    paths: {
        api: string;
        photos: string;
    }
}

@Injectable()
export class Config {
    public static apiUrl;
    public static photosDirUrl;

    constructor(private http: HttpClient) {}

    public load(): Promise<any> {
        return this.http.get("../assets/config/server-conf.json")
            .toPromise()
            .then((config: ConfigFileObject) => {
                let ip = config.hostIpAddr;
                console.log("Server IP : " + ip);
                Config.apiUrl = `http://${ip}${config.paths.api}`;
                Config.photosDirUrl = `http://${ip}${config.paths.photos}`;
            });
    }
}
