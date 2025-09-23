<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run()
    {
        $colombiaId = \App\Models\Country::where('code', 'CO')->first()->id;
        
        $states = [
            ['name' => 'Bogotá D.C.', 'country_id' => $colombiaId],
            ['name' => 'Antioquia', 'country_id' => $colombiaId],
            ['name' => 'Valle del Cauca', 'country_id' => $colombiaId],
        ];

        foreach ($states as $state) {
            \App\Models\State::create($state);
        }
    }
}