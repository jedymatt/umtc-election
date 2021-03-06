<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
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
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $this->faker->randomElement(Department::all()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function cdsg()
    {
        return $this->state(function (array $attributes) {
            return [
                'election_type_id' => ElectionType::whereName('CDSG')->firstOrFail(),
                'department_id' => null,
            ];
        });
    }

    public function ended()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween(),
                'end_at' => Carbon::now(),
            ];
        });
    }

    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween(),
                'end_at' => Carbon::now(),
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
}
