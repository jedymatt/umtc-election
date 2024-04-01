<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.dashboard'));
        $response->assertOk();
    }
}
