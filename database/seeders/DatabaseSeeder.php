<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
            Admin::factory()->superAdmin()->create([
                'email' => 'admin@example.com',
            ]);

            Admin::factory()->create([
                'email' => 'basic@example.com'
            ]);

            User::factory()->create([
                'name' => 'Juan Dela Cruz',
                'email' => 'j.delacruz.123456.tc@umindanao.edu.ph'
            ]);

            $departments = Department::pluck('id');
            $departmentsLength = count($departments);

            Election::factory()
                ->count($departmentsLength * 2)
                ->state(new Sequence(function ($sequence) use ($departments, $departmentsLength) {
                    $index = $sequence->index % $departmentsLength;
                    return ['department_id' => $departments[$index]];
                }))
                ->create();


            Election::factory()
                ->count($departmentsLength)
                ->ended()
                ->state(new Sequence(function ($sequence) use ($departments, $departmentsLength) {
                    $index = $sequence->index;
                    return ['department_id' => $departments[$index]];
                }))
                ->create();
//            Department::all()->each(function ($department) {
//                Election::factory(2)
//                    ->has(Candidate::factory()
//                        ->count(7)
//                        ->hasAttached(
//                            Vote::factory(3)
//                        )
//                        ->for(User::factory()
//                            ->state(new Sequence(
//                                fn(Sequence $sequence) => ['department_id' => Department::all()->random()],
//                            ))
//                        ),
//
//                    )->create([
//                        'department_id' => $department->id,
//                    ]);
//
//                Election::factory(1)->ended()->create([
//                    'department_id' => $department->id
//                ]);
//            });
        }
    }
}
