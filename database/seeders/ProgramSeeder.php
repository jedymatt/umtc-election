<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs=[

            ['name'=> 'Bacehlor of Science in Accountancy'],
            ['name'=> 'Bachelor of Science in Accounting Technology'],
            ['name'=> 'Bacehlor of Science in Business Administration major in Financial Management'],
            ['name'=> 'Bacehlor of Science in Business Administration major in Human Resource Management'],
            ['name'=> 'Bacehlor of Science in Marketing Management'],
            ['name'=> 'Bacehlor of Science in Hotel and Restaurant Management'],
            ['name'=> 'Bacehlor of Science in Tourism Management'],
            ['name'=> 'Bachelor of Elementary Education-Generalist'],
            ['name'=> 'Bachelor of Secondary Education major in Biological Science'],
            ['name'=> 'Bachelor of Secondary Education major in English'],
            ['name'=> 'Bachelor of Secondary Education major in Mathematics'],
            ['name'=> 'Bachelor of Secondary Education major in Social Studies'],
            ['name'=> 'Bacehlor of Science in Computer Science'],
            ['name'=> 'Bacehlor of Bachelor of Arts in English '],
            ['name'=> 'Bacehlor of Science in Information Technology'],
            ['name'=> 'Bacehlor of Science in Psycology'],
            ['name'=> 'Bacehlor of Science in Electrical Engineering'],
            ['name'=> 'Bachelor of Science in Electronics and Communication Engineering'],
            ['name'=> 'Bacehlor of Science in Computer Engineering'],
            ['name'=> 'Bacehlor of Science in Criminology'],
        ];

        \App\Models\Program::insert($programs);
        //
    }
}
