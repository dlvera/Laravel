<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        City::create(['name' => 'La Lisa', 'state_id' => 1]);
        City::create(['name' => 'Bauta', 'state_id' => 2]);
        // Agregar más ciudades
    }
}