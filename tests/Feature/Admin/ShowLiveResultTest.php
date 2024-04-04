<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowLiveResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_can_be_rendered(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()->dsg()->ongoing()
            ->has(Candidate::factory(15)
                ->sequence(...Position::all()->map(fn ($position) => ['position_id' => $position->id]))
            )
            ->createOne();
        $response = $this->actingAs($user, 'admin')->get(route('admin.elections.result', $election));
        $response->assertOk();
    }
}
