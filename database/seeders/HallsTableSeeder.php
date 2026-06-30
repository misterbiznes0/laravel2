<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallsTableSeeder extends Seeder
{
    public function run()
    {
        Hall::create(['name' => 'Зал 1 (Красный)', 'rows' => 8, 'seats_per_row' => 10]);
        Hall::create(['name' => 'Зал 2 (Синий)', 'rows' => 10, 'seats_per_row' => 12]);
        Hall::create(['name' => 'Зал 3 (Золотой)', 'rows' => 6, 'seats_per_row' => 8]);
        Hall::create(['name' => 'VIP Зал', 'rows' => 4, 'seats_per_row' => 6]);
    }
}