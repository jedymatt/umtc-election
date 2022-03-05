<?php

namespace Database\Seeders;

use App\Models\ElectionType;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectionTypePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $DSGPositions = Position::whereIn('name', [
            'President',
            'Vice President',
            'Secretary',
            'Treasurer',
            'Auditor',
            'P.I.O',
            'Business Manager',
        ])->get();

        $CDSGPositions = Position::whereIn('name', [
            'President',
            'Vice President for Internal Affairs',
            'Vice President for External Affairs',
            'Secretary',
            'Treasurer',
            'Auditor',
            'Business Manager',
        ])->get();

        ElectionType::whereName('DSG')->firstOrFail()
            ->positions()
            ->sync($DSGPositions);

        ElectionType::whereName('CDSG')->firstOrFail()
            ->positions()
            ->sync($CDSGPositions);
    }
}
