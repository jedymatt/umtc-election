<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $yearLevels = [
            ['name' => '1st Year'],
            ['name' => '2nd Year'],
            ['name' => '3rd Year'],
            ['name' => '4th Year'],
        ];

        \App\Models\YearLevel::insert($yearLevels);
    }
}
