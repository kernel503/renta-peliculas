<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    $users = User::all()->toArray();
    $collect = collect([]);
    foreach ($users as $user) {
      $collect->push([
        'id' => $user['id'],
        'nombre' => $user['name'],
        'correo' => $user['email'],
        'isAdmin' => $user['is_admin'] ? 'Administrador' : 'Cliente',
      ]);
    }
    return $collect;
  }

  public function headings(): array
  {
    return [
      'id',
      'Nombre',
      'Correo',
      'Rol',
    ];
  }
}
