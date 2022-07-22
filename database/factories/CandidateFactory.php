<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
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
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'position_id' => $this->faker->randomElement(Position::all()),
            'election_id' => Election::factory(),
        ];
    }

    public function configure(): self
    {
        return $this->afterMaking(function (Candidate $candidate) {
            if ($candidate->has('election')
                && $candidate->election->election_type_id == ElectionType::TYPE_DSG) {
                $candidate->user->department_id = $candidate->election->department_id;
                $candidate->position_id = Position::all()->random()->id;
                $candidate->user->save();
            }
        });
    }
}
