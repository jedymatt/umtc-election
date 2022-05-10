<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Program;
use App\Models\YearLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $studentId = $this->faker->unique()->randomNumber(6, true);

        $name = $firstName . ' ' . $lastName;
        $email = strtolower(substr($firstName, 0, 1) . '.' . $lastName . '.' . $studentId . '.tc@umindanao.edu.ph');

        return [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),

            'department_id' => $this->faker->randomElement(Department::all()),
            'program_id' => $this->faker->randomElement(Program::all()),
            'year_level_id' => $this->faker->randomElement(YearLevel::all()),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
