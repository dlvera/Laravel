<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'identifier' => 'ADMIN001',
            'name' => 'Administrador Principal',
            'email' => 'admin@mailer.com',
            'password' => Hash::make('Admin123!'),
            'cedula' => '00000000001',
            'birth_date' => '1980-01-01',
            'phone' => '3001234567',
            'city_id' => 1, // Bogotá o la ciudad principal
            'role' => 'admin'
        ]);

        // Usuario normal para testing
        User::create([
            'identifier' => 'USER001',
            'name' => 'Usuario Normal',
            'email' => 'user@example.com',
            'password' => Hash::make('User123!'),
            'cedula' => '10000000001',
            'birth_date' => '1990-01-01',
            'phone' => '3001234568',
            'city_id' => 1,
            'role' => 'user'
        ]);

        $this->command->info('Usuario administrador creado exitosamente!');
        $this->command->info('Email: admin@mailer.com');
        $this->command->info('Password: Admin123!');
    }
}