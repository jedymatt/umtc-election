<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.index'));
        $response->assertOk();
    }

    public function test_index_page_can_be_rendered_with_an_election(): void
    {
        $user = Admin::factory()->create();
        Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5))
            ->has(Vote::factory(30))
            ->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.index'));
        $response->assertOk();
    }

    public function test_show_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();
        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5))
            ->has(Vote::factory(30))
            ->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.show', $election));
        $response->assertOk();
    }

    public function test_create_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.create'));
        $response->assertOk();
    }
}
