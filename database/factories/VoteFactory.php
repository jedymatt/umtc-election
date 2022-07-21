<?php

namespace Database\Factories;

use App\Models\Election;
use App\Models\ElectionType;
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

            'user_id' => User::factory(),
            'election_id' => $this->faker->randomElement(Election::all()),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Vote $vote) {
            if ($vote->has('election')
                && $vote->election->election_type_id == ElectionType::TYPE_DSG) {
                $vote->user->department_id = $vote->election->department_id;

                $candidates = $this->faker->randomElements($vote->election->candidates, rand(1, $vote->election->candidates->count()));

                $vote->candidates()->saveMany($candidates);
                $vote->push();
            }
        });
    }
}
