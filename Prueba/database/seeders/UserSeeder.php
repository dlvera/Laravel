<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@mailersa.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        // Crear usuarios de prueba
        User::factory(10)->create();
    }
}