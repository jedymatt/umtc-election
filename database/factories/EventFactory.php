<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Election;
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

    public function hasFullActiveDsgElections(): EventFactory
    {
        $sequence = Department::all()->map(function ($department) {
            return ['department_id' => $department->id];
        });

        return $this->has(Election::factory()->count($sequence->count())
            ->state(new Sequence(...$sequence->toArray())));
    }

    public function hasFullEndedDsgElections(): EventFactory
    {
        $sequence = Department::all()->map(function ($department) {
            return ['department_id' => $department->id];
        });

        return $this->has(
            Election::factory()
                ->count($sequence->count())
                ->ended()
                ->state(new Sequence(...$sequence->toArray()))
        );
    }
}
