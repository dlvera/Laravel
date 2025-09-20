<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        Country::create(['name' => 'Cuba']);
        // Agregar más países si es necesario
    }
}