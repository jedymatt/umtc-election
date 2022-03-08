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
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now()->addDays(3),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'election_type_id' => $this->faker->randomElement(ElectionType::all()),
            'department_id' => $this->faker->randomElement(Department::all()),
        ];
    }
}
