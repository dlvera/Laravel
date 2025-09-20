<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            EmailSeeder::class,
            AdminUserSeeder::class,
        ]);

        
    }
}