<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\Event;
use App\Models\User;
use App\Models\Vote;
use App\Models\Winner;
use Illuminate\Database\Seeder;

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
            Admin::factory()->superAdmin()->create([
                'email' => 'admin@example.com',
            ]);

            Admin::factory()->create([
                'email' => 'basic@example.com',
            ]);

            User::factory()->create([
                'name' => 'Juan Dela Cruz',
                'email' => 'j.delacruz.123456.tc@umindanao.edu.ph',
            ]);

            $this->call(EventSeeder::class);


//            Election::factory()
//                ->count(7)
//                ->has(
//                    Candidate::factory()
//                        ->count(20)
//                )
//                ->has(
//                    Vote::factory()
//                        ->count(20)
//                )
//                ->create();
//
//
//            Election::factory()
//                ->count(7)
//                ->ended()
//                ->has(
//                    Candidate::factory()
//                        ->count(20)
//                )
//                ->has(
//                    Vote::factory()
//                        ->count(20)
//                )
//                ->create();
        }
    }
}
