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
            'name' => 'Administrador',
            'email' => 'admin@mailer.com',
            'password' => Hash::make('AdminPassword1!'),
            'identifier' => 100001,
            'phone' => '1234567890',
            'document' => '12345678901',
            'birthdate' => '1980-01-01',
            'city_id' => 1, // Asumiendo que existe una ciudad con ID 1
            'is_admin' => true,
        ]);
    }
}