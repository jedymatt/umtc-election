<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;

class ElectionFactory extends Factory
{
    protected $model = Election::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->words(3, true),
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

    public function configure()
    {
        return $this->afterCreating(function (Election $election) {
            $positionIds = Position::pluck('id');

            foreach ($positionIds as $positionId) {
                Candidate::factory()
                    ->count(rand(1, 5))
                    ->hasAttached(Vote::factory()
                        ->count(rand(1, 5))
                        ->for(User::factory()
                            ->state(new Sequence(['department_id' => $election->department_id]))))
                    ->create([
                        'election_id' => $election->id,
                        'position_id' => $positionId,
                    ]);
            }

        });
    }
}
