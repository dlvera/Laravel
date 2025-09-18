<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run()
    {
        // Ejemplo para Cuba
        State::create(['name' => 'La Habana', 'country_id' => 1]);
        State::create(['name' => 'Artemisa', 'country_id' => 1]);
        // Agregar más estados
    }
}