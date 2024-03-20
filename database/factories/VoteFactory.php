<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => $this->faker->randomElement(User::all()),
            'election_id' => $this->faker->randomElement(Election::all()),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Vote $vote) {
            $candidates = $vote->election->candidates;

            $candidates->groupBy('position_id')
                ->each(
                    fn ($candidates) => $vote->candidates()->attach($candidates->random())
                );

        });
    }
}
