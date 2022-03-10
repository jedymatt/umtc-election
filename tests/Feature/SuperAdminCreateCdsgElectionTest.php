<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Election;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SuperAdminCreateCdsgElectionTest extends TestCase
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

    public function test_empty_elections()
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

    public function test_null_elections()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
                'elections' => null,
            ]);

        $response->assertInvalid();
    }

    public function test_missing_elections()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
            ]);

        $response->assertSessionMissing(['elections']);
    }

    public function test_invalid_lack_elections()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $departments = Department::limit(3)->get();
        $elections = $departments->mapWithKeys(function (Department $department) {
            return [
                $department->id => $this->faker->randomElement($department->availableDsgElections),
            ];
        })->toArray();

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
                'elections' => $elections,
            ]);

        $response->assertSessionMissing(['elections']);
    }

    public function test_input_election_in_every_department()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $departments = Department::with('availableDsgElections')->get();
        $elections = $departments->mapWithKeys(function (Department $department) {
            $election = $this->faker->randomElement($department->availableDsgElections);

            return [$department->id => $election->id];
        })->toArray();

        $response = $this->actingAs($superAdmin, 'admin')
            ->post('admin/cdsg-elections', [
                'title' => $this->faker->word(),
                'description' => $this->faker->paragraph(),
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->addDay(),
                'elections' => $elections,
            ]);

        $response->assertValid();
    }

    public function test_has_null_election()
    {
        $superAdmin = Admin::factory()->superAdmin()->create();

        $departments = Department::with('availableDsgElections')->get();
        $elections = $departments->mapWithKeys(function (Department $department) {
            $election = $this->faker->randomElement($department->availableDsgElections);
            return [$department->id => $election->id];
        })->toArray();

        $elections[$departments->first()->id] = null;

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
}
