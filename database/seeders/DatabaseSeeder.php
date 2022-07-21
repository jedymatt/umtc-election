<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            DepartmentSeeder::class,
            ElectionTypeSeeder::class,
            PositionSeeder::class,
            ElectionTypePositionSeeder::class,
        ]);

        if (config('app.env') === 'local') {
            Admin::factory()->superAdmin()->create([
                'email' => 'admin@example.com',
            ]);

            User::factory()->create([
                'name' => 'Juan Dela Cruz',
                'email' => 'j.delacruz.123456.tc@umindanao.edu.ph',
            ]);
        }
    }
}
