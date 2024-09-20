import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { InUser, InUserUpdate } from '../models/user.model';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  private _baseUrl = `${environment.api_base_url}/users`;

  constructor(private httpCLient: HttpClient) {}
  findAll() {
    return this.httpCLient.get<InUser[]>(this._baseUrl);
  }

  findOne(id: number) {
    return this.httpCLient.get<InUser>(`${this._baseUrl}/${id}`);
  }

  create(user: InUserUpdate) {
    return this.httpCLient.post<InUser>(this._baseUrl, user);
  }

  put(id: number, user: InUser) {
    return this.httpCLient.put<InUser>(`${this._baseUrl}/${id}`, user);
  }

  delete(id: number) {
    return this.httpCLient.delete(`${this._baseUrl}/${id}`);
  }
}
