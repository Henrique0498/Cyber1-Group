export interface InUser {
  id: number;
  name: string;
  age: number;
}

export interface InUserUpdate extends Omit<InUser, 'id'> {}
