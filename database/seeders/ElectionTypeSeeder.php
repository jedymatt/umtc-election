<?php

namespace Database\Seeders;

use App\Models\ElectionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $electionTypes = [
            [
                'id' => ElectionType::DSG,
                'name' => 'DSG',
            ],
            [
                'id' => ElectionType::CDSG,
                'name' => 'CDSG',
            ],
        ];

        ElectionType::insert($electionTypes);
    }
}
