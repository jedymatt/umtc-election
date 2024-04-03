<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElectionResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();
        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5))
            ->has(Vote::factory(30))
            ->create();

        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.result', $election));
        $response->assertOk();
    }
}
