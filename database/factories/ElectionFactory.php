<?php

namespace Database\Factories;

use App\Enums\ElectionType;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ElectionFactory extends Factory
{
    protected $model = Election::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->words(asText: true),
            'description' => $this->faker->text(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(3),
            'type' => ElectionType::Dsg,
            'department_id' => $this->faker->randomElement(Department::all()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function dsg()
    {
        return $this->state(function (array $attributes) {
            return ['type' => ElectionType::Dsg];
        });
    }

    public function cdsg()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ElectionType::Cdsg,
                'department_id' => null,
            ];
        });
    }

    public function ended()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
                'end_at' => $this->faker->dateTimeBetween('-1 month, +1 day', '-1 day'),
            ];
        });
    }

    public function finished()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
                'end_at' => $this->faker->dateTimeBetween('-1 month, +1 day', '-1 day'),
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => Carbon::now()->addDay(),
                'end_at' => Carbon::now()->addDays(4),
            ];
        });
    }

    public function ongoing()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => Carbon::now()->addDay(),
                'end_at' => Carbon::now()->addDays(4),
            ];
        });
    }

    public function candidates(int $count)
    {
        return $this->has(
            Candidate::factory($count)
                ->sequence(...Position::all()->map(fn (Position $position) => ['position_id' => $position->id])->toArray())
        );
    }
}
