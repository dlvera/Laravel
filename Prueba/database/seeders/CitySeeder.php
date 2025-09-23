<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
     public function run()
    {
        $bogotaId = \App\Models\State::where('name', 'Bogotá D.C.')->first()->id;
        
        $cities = [
            ['name' => 'Bogotá', 'code' => 1, 'state_id' => $bogotaId],
            ['name' => 'Medellín', 'code' => 2, 'state_id' => $bogotaId],
            ['name' => 'Cali', 'code' => 3, 'state_id' => $bogotaId],
        ];

        foreach ($cities as $city) {
            \App\Models\City::create($city);
        }
    }
}