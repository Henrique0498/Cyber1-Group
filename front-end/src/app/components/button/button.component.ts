import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-button',
  standalone: true,
  imports: [],
  templateUrl: './button.component.html',
  styleUrl: './button.component.scss',
})
export class ButtonComponent {
  @Input() type: 'button' | 'submit' = 'button';
  @Input() size: 'default' | 'small' = 'default';
  @Input() color: 'primary' | 'success' | 'danger' = 'primary';
  @Input() disabled: boolean = false;
}
