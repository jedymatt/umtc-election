<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SuperAdminCreateCDSGElectionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_forbid_non_super_admin()
    {
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admin')
            ->post('admin/cdsg-elections', []);

        $response->assertForbidden();
    }

    public function test_no_input_departments()
    {
        $superAdmin = Admin::factory()->create([
            'is_super_admin' => true,
        ]);

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
}
