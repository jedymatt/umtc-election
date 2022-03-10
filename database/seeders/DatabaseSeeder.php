<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            DepartmentSeeder::class,
            ElectionTypeSeeder::class,
            PositionSeeder::class,
            ElectionTypePositionSeeder::class,
            ProgramSeeder::class,
            YearLevelSeeder::class,
        ]);

        if (config('app.debug')) {
            Admin::factory()->create([
                'email' => 'admin@example.com',
                'is_super_admin' => true,
            ]);
            User::factory(20)->create();
            Department::all()->each(function ($department) {
                Election::factory(rand(1, 3))->create([
                    'department_id' => $department->id,
                ]);
            });
            Candidate::factory(20)->create();
        }
    }
}
