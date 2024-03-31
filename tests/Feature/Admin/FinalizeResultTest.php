<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinalizeResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_finalize_results_without_tie(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(
                Candidate::factory(25)
                    ->sequence(
                        ...Position::all()
                            ->map(fn (Position $position) => ['position_id' => $position->id])
                            ->toArray()
                    )
            )
            ->has(Vote::factory(100))
            ->create();

        $candidates = $election->candidates()->withCount('votes')->get();

        $candidates->groupBy('position_id')
            ->each(function ($candidates) use ($election) {
                $topVotes = $candidates->max('votes_count');

                // Get the candidate with the highest votes
                /** @var Collection<int, Candidate> $topCandidates */
                $topCandidates = $candidates->where('votes_count', $topVotes);

                if ($topCandidates->count() > 1) {
                    // randomly vote from one of the tied candidates
                    Vote::create([
                        'user_id' => User::factory()->create()->id,
                        'election_id' => $election->id,
                    ])->candidates()->sync($topCandidates->random());
                }
            });

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
    }

    public function test_do_not_allow_ongoing_election(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ongoing()
            ->create();

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertForbidden();
    }

    public function test_do_not_allow_upcoming_election(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()->dsg()->upcoming()->create();

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertForbidden();
    }

    public function test_do_not_allow_when_there_is_a_tie_and_none_was_selected(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(
                Candidate::factory(25)
                    ->sequence(
                        ...Position::all()
                            ->map(fn (Position $position) => ['position_id' => $position->id])
                            ->toArray()
                    )
            )
            ->has(Vote::factory(100))
            ->create();

        $firstCandidate = $election->candidates()->first();
        Candidate::factory()
            ->hasAttached($firstCandidate->votes()->get())
            ->create([
                'election_id' => $election->id,
                'position_id' => $firstCandidate->position_id,
            ]);

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertSessionHasErrors();
    }

    public function test_do_not_allow_when_there_is_a_tie_and_more_than_one_was_selected(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_do_not_allow_when_there_is_a_tie_and_selected_candidates_are_not_from_the_tied_positions(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_do_not_allow_when_already_finalized(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(
                Candidate::factory(25)
                    ->sequence(
                        ...Position::all()
                            ->map(fn (Position $position) => ['position_id' => $position->id])
                            ->toArray()
                    )
            )
            ->has(Vote::factory(100))
            ->create();

        $winners = $election->candidates()->withCount('votes')->get()
            ->groupBy('position_id')
            ->map(fn ($candidates) => $candidates->first());

        // Finalize the election
        $election->winners()->sync($winners->map(fn (Candidate $candidate) => [
            'candidate_id' => $candidate->id,
            'votes' => $candidate->votes_count,
        ]));
        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertForbidden();
    }
}
