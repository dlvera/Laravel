<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Verificar si el usuario administrador ya existe
        $adminExists = User::where('email', 'admin@mailersa.com')->exists();
        
        // Crear usuario administrador
        User::create([
            'identifier' => '1000000000',
            'name' => 'Administrador',
            'email' => 'admin@mailersa.com',
            'password' => Hash::make('password'),
            'cedula' => '1000000000',
            'birth_date' => '1990-01-01',
            'phone' => '3000000000',
            'is_active' => true,
            'is_admin' => true,
            'city_id' => 1, // Ajustar según exista en la base de datos
        ]);
    }
}