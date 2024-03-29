<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Candidate;
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

            Election::factory()
                ->dsg()
                ->forEachSequence(
                    // upcoming
                    ['start_at' => now()->addDays(1), 'end_at' => now()->addDays(2)],
                    // ongoing
                    ['start_at' => now()->subDays(1), 'end_at' => now()->addDays(1)],
                    // ended
                    ['start_at' => now()->subDays(2), 'end_at' => now()->subDays(1)],
                )
                ->has(
                    Candidate::factory(30)
                        ->sequence(
                            ...Position::all()
                                ->map(fn (Position $position) => ['position_id' => $position->id])
                                ->toArray()
                        )
                )
                ->has(Vote::factory(250))
                ->create();
        }
    }
}
