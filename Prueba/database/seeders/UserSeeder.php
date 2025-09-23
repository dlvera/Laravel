<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuarios de prueba solo si no existen
        if (User::count() <= 1) {
            User::factory(10)->create();
            Log::info('10 usuarios de prueba creados.');
        } else {
            Log::info('Ya existen usuarios en la base de datos, omitiendo creación de usuarios de prueba.');
        }
    }
}