<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'department_id' => $this->faker->randomElement(Department::all()),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_super_admin' => true,
                'department_id' => null,
            ];
        });
    }
}
