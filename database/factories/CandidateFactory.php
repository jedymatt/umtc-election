<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'position_id' => $this->faker->randomElement(Position::all()),
            'election_id' => Election::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Candidate $candidate) {
            $candidate->user->update(['department_id' => $candidate->election->department_id]);
        });
    }
}
