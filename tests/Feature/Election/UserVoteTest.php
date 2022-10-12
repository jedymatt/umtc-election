<?php

namespace Tests\Feature\Election;

use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserVoteTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_voters_can_visit_the_cdsg_election_voting_page()
    {
        $user = User::factory()->create();

        $election = Election::factory()->state([
            'election_type_id' => ElectionType::TYPE_CDSG,
        ])->has(
            Candidate::factory()->state([
                'user_id' => $user->id,
            ])
        )->create();

        $this->actingAs($user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertStatus(200);
    }

    public function test_non_voters_cannot_visit_the_cdsg_election_voting_page()
    {
        $user = User::factory()->create();

        $election = Election::factory()->state([
            'election_type_id' => ElectionType::TYPE_CDSG,
        ])->create();

        $this->actingAs($user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }

    public function test_cdsg_election_voters_can_vote()
    {
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

    public function test_cdsg_election_non_voters_cannot_vote()
    {
        $user = User::factory()->create();

        $election = Election::factory()
        ->has(Candidate::factory())
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
            ->assertForbidden();
    }

    public function test_voters_can_visit_the_dsg_election_voting_page()
    {
        $user = User::factory()->create();

        $election = Election::factory()->state([
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $user->department_id,
        ])->create();

        $this->actingAs($user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertSuccessful();
    }

    public function test_dsg_election_should_should_not_visit_when_the_voter_does_not_belong_to_the_election_department()
    {
        $user = User::factory()->create();

        $election = Election::factory()->state([
            'election_type_id' => ElectionType::TYPE_DSG,
        ])
        ->for(Department::factory())
        ->create();

        $this->actingAs($user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }

    public function test_dsg_election_should_should_not_visit_when_the_voter_already_voted()
    {
        $user = User::factory()->create();

        $election = Election::factory()->state([
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $user->department_id,
        ])
        ->has(Vote::factory()->state([
            'user_id' => $user->id,
        ]))
        ->create();

        $this->actingAs($user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }

    public function test_dsg_election_voters_can_submit_vote()
    {
        $user = User::factory()->create();

        $election = Election::factory()
        ->state([
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $user->department_id,
        ])
        ->has(Candidate::factory()->has(User::factory()))
        ->create();

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

    public function test_cdsg_election_should_not_allow_multiple_votes()
    {
        $user = User::factory()->create();

        $election = Election::factory()
        ->state([
            'election_type_id' => ElectionType::TYPE_CDSG,
        ])
        ->has(Candidate::factory()->state([
            'user_id' => $user->id,
        ]))
        ->create();

        $this->actingAs($user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertStatus(302)
            ->assertRedirect('/elections');

        $this->actingAs($user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }

    public function test_dsg_election_should_not_allow_multiple_votes()
    {
        $user = User::factory()->create();

        $election = Election::factory()
        ->state([
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $user->department_id,
        ])
        ->create();

        $this->actingAs($user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertStatus(302)
            ->assertRedirect('/elections');

        $this->actingAs($user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }
}
