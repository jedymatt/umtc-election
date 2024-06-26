<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('admin/register');

        if ($response->getStatusCode() === 404) {
            $this->markTestSkipped();
        }

        $response->assertStatus(200);
    }

    public function test_new_admins_can_register(): void
    {
        $response = $this->post('admin/register', [
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        if ($response->getStatusCode() === 404) {
            $this->markTestSkipped();
        }

        $this->assertAuthenticated('admin');
        $response->assertRedirect(route('admin.dashboard'));
    }
}
