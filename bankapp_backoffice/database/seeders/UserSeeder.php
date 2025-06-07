<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de usuarios a importar (simulación)
        $admin = User::create([
           'name' => 'administrador dos',
           'email' => 'admin02@gmail.com',
           'password' => Hash::make('ofloda01'),
           'authorized'=>true,
           'rol_id'=>1
       ]);
       $admin->assignRole('Admin');


       $cajero = User::create([
           'name' => 'cajero',
           'email' => 'cajero@gmail.com',
           'password' => Hash::make('ofloda01'),
           'authorized'=>true,
           'rol_id'=>2
       ]);
       $cajero->assignRole('Cajero');

       $atencion = User::create([
           'name' => 'atencion',
           'email' => 'atencion@gmail.com',
           'password' => Hash::make('ofloda01'),
           'authorized'=>true,
           'rol_id'=>3
       ]);
       $atencion->assignRole('Atencion');


    }
}
