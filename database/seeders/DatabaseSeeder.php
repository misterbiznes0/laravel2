<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            HallsTableSeeder::class,
            MoviesTableSeeder::class,
            MovieSessionsTableSeeder::class,
        ]);
    }
}