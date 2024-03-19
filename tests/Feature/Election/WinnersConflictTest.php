<?php

namespace Tests\Feature\Election;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\Winner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WinnersConflictTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_conflict(): void
    {
        $election = Election::factory()->create();

        Winner::factory()->count(2)->create([
            'election_id' => $election->id,
            'votes' => 100,
            'candidate_id' => Candidate::factory()->create([
                'position_id' => Position::first()->id,
            ]),
        ]);

        $this->assertTrue($election->hasConflictedWinners());
    }

    public function test_has_no_conflict(): void
    {
        $this->markTestIncomplete();

        $election = Election::factory()->create();

        Winner::factory()->create([
            'election_id' => $election->id,
            'votes' => 100,
            'candidate_id' => Candidate::factory()->create([
                'position_id' => Position::first()->id,
            ]),
        ]);

        Winner::factory()->create([
            'election_id' => $election->id,
            'votes' => 50,
            'candidate_id' => Candidate::factory()->create([
                'position_id' => Position::first()->id,
            ]),
        ]);

        $this->assertFalse($election->hasConflictedWinners());
    }

    public function test_has_no_conflict_with_no_winners(): void
    {
        $election = Election::factory()->create();

        $this->assertFalse($election->hasConflictedWinners());
    }

    public function test_has_no_conflict_same_number_of_votes_but_different_position(): void
    {
        $election = Election::factory()->create();

        Winner::factory()->create([
            'election_id' => $election->id,
            'votes' => 100,
            'candidate_id' => Candidate::factory()->create([
                'position_id' => Position::first()->id,
            ]),
        ]);

        Winner::factory()->create([
            'election_id' => $election->id,
            'votes' => 100,
            'candidate_id' => Candidate::factory()->create([
                'position_id' => Position::latest('id')->limit(1)->first()->id,
            ]),
        ]);

        $this->assertFalse($election->hasConflictedWinners());
    }
}
