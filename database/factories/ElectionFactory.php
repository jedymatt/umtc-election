<?php

namespace Database\Factories;

use App\Enums\ElectionType;
use App\Models\Department;
use App\Models\Election;
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

    public function dsg(): static
    {
        return $this->state(function (array $attributes) {
            return ['type' => ElectionType::Dsg];
        });
    }

    public function cdsg(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ElectionType::Cdsg,
                'department_id' => null,
            ];
        });
    }

    public function ended(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => now()->subDays(2),
                'end_at' => now()->subDay(),
            ];
        });
    }

    public function finished(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween('-1 year', '-1 month'),
                'end_at' => $this->faker->dateTimeBetween('-1 month, +1 day', '-1 day'),
            ];
        });
    }

    public function pending(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => Carbon::now()->addDay(),
                'end_at' => Carbon::now()->addDays(4),
            ];
        });
    }

    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => Carbon::now()->addDays(1),
                'end_at' => Carbon::now()->addDays(2),
            ];
        });
    }

    public function ongoing(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => Carbon::now()->subMinute(),
                'end_at' => Carbon::now()->addDays(4),
            ];
        });
    }
}
