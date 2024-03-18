<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
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

            Election::factory()
                ->dsg()
                ->has(
                    Candidate::factory(50)
                        ->sequence(
                            ...Position::all()
                                ->map(fn (Position $position) => ['position_id' => $position->id])
                                ->toArray()
                        )
                )
                ->createOne();
        }
    }
}
