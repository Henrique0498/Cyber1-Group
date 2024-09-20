import { Component } from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { UserService } from '../../services/user.service';
import { InUser, InUserUpdate } from '../../models/user.model';
import { ButtonComponent } from '../../components/button/button.component';
import { InputComponent } from '../../components/input/input.component';
import { AlertComponent } from '../../components/alert/alert.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    ButtonComponent,
    InputComponent,
    AlertComponent,
  ],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss',
})
export default class HomeComponent {
  users$: InUser[] = [];
  userForm: FormGroup;
  alertDisabled = true;
  alertMessage = '';
  alertType: 'success' | 'error' = 'success';

  constructor(private userService: UserService) {
    this.getUsers();

    this.userForm = new FormGroup({
      id: new FormControl({ value: '', disabled: true }),
      name: new FormControl('', Validators.required),
      age: new FormControl('', [Validators.required, Validators.min(1)]),
    });
  }

  getUsers() {
    this.userService.findAll().subscribe({
      next: (users) => (this.users$ = users),
      error: () => this.messageError('Falha ao carregar os usuários'),
    });
  }

  submitForm() {
    if (this.userForm.valid) {
      const userData = this.userForm.value as InUser;
      const id = this.userForm.get('id')?.value;

      if (id) {
        this.userService.put(id, userData).subscribe({
          next: () => {
            this.messageSuccess('Atualizado com sucesso');
            this.getUsers();
          },
          error: () => {
            this.messageError('Falha ao atualizar');
          },
        });
      } else {
        this.userService.create(userData).subscribe({
          next: () => {
            this.messageSuccess('Criado com sucesso');
            this.getUsers();
          },
          error: () => {
            this.messageError('Falha ao criar o usuário');
          },
        });
      }

      this.cleanForm();
    }
  }

  editUser(user: InUserUpdate) {
    this.userForm.patchValue(user);
  }

  cleanForm() {
    this.userForm.reset();
  }

  deleteUser(id: number) {
    if (confirm('Deseja realmente excluir?')) {
      this.userService
        .delete(id)
        .subscribe({
          next: () => {
            this.messageSuccess('Usuário excluído com sucesso');
            this.getUsers();
          },
          error: () => {
            this.messageError('Falha ao excluir o usuário');
          },
        })
        .unsubscribe();
    }
  }

  messageSuccess(message: string) {
    this.alertType = 'success';
    this.alertMessage = message;
    this.alertDisabled = false;

    this.alertTimeOut();
  }

  messageError(message: string) {
    this.alertType = 'error';
    this.alertMessage = message;
    this.alertDisabled = false;

    this.alertTimeOut();
  }

  alertTimeOut() {
    setTimeout(() => {
      this.alertDisabled = true;
    }, 2000);
  }
}
