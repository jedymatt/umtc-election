<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => str($this->faker->words(asText: true))->title(),
        ];
    }

    public function includeActiveDsgElections($totalDepartment = 7): self
    {
        $sequence = Department::limit($totalDepartment)->inRandomOrder()->get()->map(function ($department) {
            return ['department_id' => $department->id];
        });

        return $this->has(
            Election::factory()->count($sequence->count())
                ->state(new Sequence(...$sequence->toArray()))
                ->has(Candidate::factory()
                    ->count(20))
                ->has(Vote::factory()
                    ->count(100))
        );
    }

    public function includeEndedDsgElections($totalDepartment = 7): self
    {
        $sequence = Department::limit($totalDepartment)->inRandomOrder()->get()->map(function ($department) {
            return ['department_id' => $department->id];
        });

        return $this->has(
            Election::factory()
                ->count($sequence->count())
                ->ended()
                ->state(new Sequence(...$sequence->toArray()))
                ->has(Candidate::factory()
                    ->count(20))
                ->has(Candidate::factory()->has(Vote::factory()->count(100)))
                ->has(Vote::factory()
                    ->count(100))
        );
    }
}
