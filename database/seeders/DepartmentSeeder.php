<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Department of Arts and Sciences Education'],
            ['name' => 'Department of Accounting Education'],
            ['name' => 'Department of Business Administration Education'],
            ['name' => 'Department of Teacher Education'],
            ['name' => 'Department of Engineering Education'],
            ['name' => 'Department of Criminal Justice Education'],
            ['name' => 'Hospitality Management and Tourism Management'],
        ];

        \App\Models\Department::insert($departments);
    }
}
