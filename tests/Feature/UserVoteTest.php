<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserVoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_voters_can_visit_the_cdsg_election_voting_page()
    {
        $user = User::factory()->create();

        $election = Election::factory()->state([
            'election_type_id' => ElectionType::TYPE_CDSG,
        ])->has(Candidate::factory()->state([
            'user_id' => $user->id,
        ])
        )->create();

        $this->actingAs($user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertStatus(200);
    }

    public function test_cdsg_election_voters_can_vote()
    {
        /** @var User|\Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $election = Election::factory()
        ->has(Candidate::factory()->state([
            'user_id' => $user->id,
        ]))
        ->create([
            'election_type_id' => ElectionType::TYPE_CDSG,
        ]);

        $candidate = $election->candidates()->first();

        $this->actingAs($user)
            ->post('/elections/'.$election->id.'/vote', [
                'candidates' => [
                    $candidate->position_id => $candidate->id,
                ],
            ])
            ->assertStatus(302)
            ->assertRedirect('/elections');

        $vote = Vote::first();

        $this->assertDatabaseHas('votes', [
            'id' => $vote->id,
            'user_id' => $user->id,
            'election_id' => $election->id,
        ]);

        $this->assertDatabaseHas('candidate_vote', [
            'candidate_id' => $candidate->id,
            'vote_id' => $vote->id,
        ]);
    }
}
