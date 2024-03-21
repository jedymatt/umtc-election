<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
        ]);

        if (app()->isLocal()) {
            Admin::factory()->superAdmin()->create([
                'email' => 'admin@example.com',
            ]);

            User::factory()->create([
                'name' => 'Juan Dela Cruz',
                'email' => 'j.delacruz.123456.tc@umindanao.edu.ph',
            ]);

            User::factory(50)->create();

            [$one, $two] = fake()->randomElements(Department::all(), 2);

            Election::factory()
                ->dsg()
                ->state(['department_id' => $one->id])
                ->has(
                    Candidate::factory(50)
                        ->sequence(
                            ...Position::all()
                                ->map(fn (Position $position) => ['position_id' => $position->id])
                                ->toArray()
                        )
                )
                ->createOne();

            Election::factory()
                ->dsg()
                ->state(['department_id' => $two->id])
                ->ended()
                ->has(
                    Candidate::factory(50)
                        ->sequence(
                            ...Position::all()
                                ->map(fn (Position $position) => ['position_id' => $position->id])
                                ->toArray()
                        )
                )
                ->has(Vote::factory(500))
                ->createOne();

            //            Election::factory(50)
            //                ->dsg()
            //                ->ended()
            //                ->has(
            //                    Candidate::factory(50)
            //                        ->sequence(
            //                            ...Position::all()
            //                                ->map(fn (Position $position) => ['position_id' => $position->id])
            //                                ->toArray()
            //                        )
            //                )
            //                ->has(Vote::factory(500))
            //                ->create();
        }
    }
}
