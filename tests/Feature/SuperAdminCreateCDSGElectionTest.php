<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SuperAdminCreateCDSGElectionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_invalid_forbidden_non_super_admin()
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admin')
            ->post('admin/cdsg-elections', []);

        $response->assertForbidden();
    }

    public function test_invalid_no_input_departments()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
                'elections' => [],
            ]);

        $response->assertInvalid();
    }

    public function test_invalid_lack_items_in_departments()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $departments = Department::limit(3)->get();
        $elections = $departments->each(function (Department $department) {
            return [
                $department->id => $this->faker->randomElement($department->availableElections),
            ];
        });

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
                'elections' => $elections,
            ]);

        $response->assertInvalid();
    }

    public function test_input_election_in_every_department()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $departments = Department::all();
        $elections = $departments->each(function (Department $department) {
            return [
                $department->id => $this->faker->randomElement($department->availableElections),
            ];
        });

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
                'elections' => $elections,
            ]);

        $response->assertOk();
    }
}
