<?php

namespace Tests\Feature\Election;

use App\Enums\ElectionType;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserVoteTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        // This mimics the real world scenario where there can be multiple elections.
        // It also ensures the tests are querying the correct election and not these.
        Election::factory()
            ->forEachSequence(
                ['type' => ElectionType::Dsg, 'department_id' => $this->user->department_id],
                ['type' => ElectionType::Dsg],
                ['type' => ElectionType::Cdsg],
            )
            ->create();
    }

    public function test_should_not_allow_visiting_the_voting_page_of_ended_election()
    {
        $election = Election::factory()
            ->ended()
            ->create(['department_id' => $this->user->department_id]);

        $this->actingAs($this->user)
            ->post(route('elections.vote', $election))
            ->assertForbidden();
    }

    public function test_voters_can_visit_the_cdsg_election_voting_page()
    {
        $election = Election::factory()
            ->state(['type' => ElectionType::Cdsg])
            ->has(Candidate::factory()->state(['user_id' => $this->user->id]))
            ->create();

        $this->actingAs($this->user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertStatus(200);
    }

    public function test_cdsg_election_voters_can_vote()
    {
        $election = Election::factory()
            ->has(Candidate::factory()->state(['user_id' => $this->user->id]))
            ->create(['type' => ElectionType::Cdsg]);

        $candidate = $election->candidates()->first();

        $this->actingAs($this->user)
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
            'user_id' => $this->user->id,
            'election_id' => $election->id,
        ]);

        $this->assertDatabaseHas('candidate_vote', [
            'candidate_id' => $candidate->id,
            'vote_id' => $vote->id,
        ]);
    }

    public function test_cdsg_election_non_voters_cannot_vote()
    {
        $election = Election::factory()
            ->has(Candidate::factory())
            ->create([
                'type' => ElectionType::Cdsg,
            ]);

        $candidate = $election->candidates()->first();

        $this->actingAs($this->user)
            ->post('/elections/'.$election->id.'/vote', [
                'candidates' => [
                    $candidate->position_id => $candidate->id,
                ],
            ])
            ->assertForbidden();
    }

    public function test_voters_can_visit_the_dsg_election_voting_page()
    {
        $election = Election::factory()->state([
            'type' => ElectionType::Dsg,
            'department_id' => $this->user->department_id,
        ])->create();

        $this->actingAs($this->user)
            ->get('/elections/'.$election->id.'/vote')
            ->assertSuccessful();
    }

    public function test_dsg_election_should_not_allow_vote_from_different_department()
    {
        $election = Election::factory()->state([
            'type' => ElectionType::Dsg,
            'department_id' => Department::factory()->create()->id,
        ])->create();

        $this->actingAs($this->user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }

    public function test_dsg_election_voters_can_submit_vote()
    {
        $election = Election::factory()
            ->state([
                'type' => ElectionType::Dsg,
                'department_id' => $this->user->department_id,
            ])
            ->has(Candidate::factory()->has(User::factory()))
            ->create();

        $candidate = $election->candidates()->first();

        $this->actingAs($this->user)
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
            'user_id' => $this->user->id,
            'election_id' => $election->id,
        ]);

        $this->assertDatabaseHas('candidate_vote', [
            'candidate_id' => $candidate->id,
            'vote_id' => $vote->id,
        ]);
    }

    public function test_cdsg_election_should_not_allow_multiple_votes()
    {
        $election = Election::factory()
            ->state([
                'type' => ElectionType::Cdsg,
            ])
            ->has(Candidate::factory()->state([
                'user_id' => $this->user->id,
            ]))
            ->create();

        $this->actingAs($this->user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertStatus(302)
            ->assertRedirect('/elections');

        $this->actingAs($this->user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }

    public function test_dsg_election_should_not_allow_multiple_votes()
    {
        $election = Election::factory()
            ->state([
                'type' => ElectionType::Dsg,
                'department_id' => $this->user->department_id,
            ])
            ->create();

        $this->actingAs($this->user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertStatus(302)
            ->assertRedirect('/elections');

        $this->actingAs($this->user)
            ->post('/elections/'.$election->id.'/vote')
            ->assertForbidden();
    }
}
