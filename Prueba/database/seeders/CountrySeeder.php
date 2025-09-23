<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'Colombia', 'code' => 'CO'],
            ['name' => 'Estados Unidos', 'code' => 'US'],
            ['name' => 'México', 'code' => 'MX'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}