<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Winner>
 */
class WinnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'election_id' => $this->faker->randomElement(Election::all()),
            'candidate_id' => $this->faker->randomElement(Candidate::all()),
            'votes' => $this->faker->numberBetween(),
        ];
    }
}
