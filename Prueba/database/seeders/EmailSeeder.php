<?php

namespace Database\Seeders;

use App\Models\Email;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los usuarios
        $users = User::all();

        // Crear emails para cada usuario
        foreach ($users as $user) {
            // Crear 5-10 emails por usuario
            Email::factory(rand(5, 10))->create([
                'user_id' => $user->id,
                'status' => 'sent',
                'sent_at' => now()->subDays(rand(1, 30)),
            ]);

            // Crear algunos borradores
            Email::factory(rand(1, 3))->create([
                'user_id' => $user->id,
                'status' => 'draft',
                'sent_at' => null,
            ]);
        }
    }
}