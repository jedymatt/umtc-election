<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
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
            ->has(Candidate::factory(5)->state(['position_id' => Position::inRandomOrder()->first()]))
            ->has(Vote::factory(50))
            ->create();

        $candidates = $election->candidates()->withCount('votes')->get();
        $topVotes = $candidates->max('votes_count');
        $topCandidate = $candidates->where('votes_count', $topVotes)->first();
        // ensure it isn't tied with another candidate
        Vote::create([
            'user_id' => User::factory()->create()->id,
            'election_id' => $election->id,
        ])->candidates()->sync($topCandidate);

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('winners', [
            'election_id' => $election->id,
            'candidate_id' => $topCandidate->id,
        ]);
    }

    public function test_finalize_with_a_tie(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5)->state(['position_id' => Position::inRandomOrder()->first()]))
            ->has(Vote::factory(50))
            ->create();

        $candidates = $election->candidates()->withCount('votes')->get()
            ->sortByDesc('votes_count');
        $topVotedCandidate = $candidates->first();

        // Create a tie
        $anotherTopVotedCandidate = Candidate::factory()
            ->hasAttached($topVotedCandidate->votes()->get())
            ->create([
                'election_id' => $election->id,
                'position_id' => $topVotedCandidate->position_id,
            ]);

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election), [
            'candidates' => [
                $topVotedCandidate->position->name => $anotherTopVotedCandidate->id,
            ],
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('winners', [
            'election_id' => $election->id,
            'candidate_id' => $anotherTopVotedCandidate->id,
        ]);
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
            ->has(Candidate::factory(5)->state(['position_id' => Position::inRandomOrder()->first()]))
            ->has(Vote::factory(50))
            ->create();

        $candidates = $election->candidates()->withCount('votes')->get();
        $topCandidate = $candidates->sortByDesc('votes_count')->first();
        Candidate::factory()
            ->hasAttached($topCandidate->votes()->get())
            ->create([
                'election_id' => $election->id,
                'position_id' => $topCandidate->position_id,
            ]);
        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertSessionHasErrors();
    }

    public function test_do_not_allow_when_there_is_a_tie_and_selected_candidates_are_not_from_the_tied_candidates(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5)->state(['position_id' => Position::inRandomOrder()->first()]))
            ->has(Vote::factory(50))
            ->create();

        $candidates = $election->candidates()->withCount('votes')->get();
        $candidates = $candidates->sortByDesc('votes_count');
        $topCandidate = $candidates->first();
        Candidate::factory()
            ->hasAttached($topCandidate->votes()->get())
            ->create([
                'election_id' => $election->id,
                'position_id' => $topCandidate->position_id,
            ]);

        $notTiedCandidate = Candidate::factory()->create([
            'election_id' => $election->id,
            'position_id' => $topCandidate->position_id,
        ]);

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election), [
            'candidates' => [
                $notTiedCandidate->position->name => $notTiedCandidate->id,
            ],
        ]);

        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('winners', [
            'election_id' => $election->id,
            'candidate_id' => $notTiedCandidate->id,
        ]);
    }

    public function test_do_not_allow_when_there_is_a_tie_and_selected_candidates_are_from_the_different_position(): void
    {
        $user = Admin::factory()->create();

        [$firstPosition, $secondPosition] = Position::inRandomOrder()->limit(2)->get();
        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5)->state(['position_id' => $firstPosition]))
            ->has(Candidate::factory(5)->state(['position_id' => $secondPosition]))
            ->has(Vote::factory(50))
            ->create();

        $tiedCandidatesInFirstPosition = collect();
        $election->candidates()->withCount('votes')->get()
            ->groupBy('position_id')
            ->each(function ($candidates) use ($election, $tiedCandidatesInFirstPosition) {
                $candidates = $candidates->sortByDesc('votes_count');
                $topCandidate = $candidates->first();
                // create a tied candidate
                $tiedCandidate = Candidate::factory()
                    ->hasAttached($topCandidate->votes()->get())
                    ->create([
                        'election_id' => $election->id,
                        'position_id' => $topCandidate->position_id,
                    ]);

                if ($tiedCandidatesInFirstPosition->isEmpty()) {
                    $tiedCandidatesInFirstPosition->add($topCandidate);
                    $tiedCandidatesInFirstPosition->add($tiedCandidate);
                }
            });
        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election), [
            'candidates' => [
                $firstPosition->name => $tiedCandidatesInFirstPosition[0]->id,
                $secondPosition->name => $tiedCandidatesInFirstPosition[1]->id,
            ],
        ]);
        $response->assertSessionHasErrors();
    }

    public function test_do_not_allow_when_already_finalized(): void
    {
        $user = Admin::factory()->create();

        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(Candidate::factory(5)->state(['position_id' => Position::inRandomOrder()->first()]))
            ->has(Vote::factory(50))
            ->create();

        // Finalize the election
        $winners = $election->candidates()->withCount('votes')->first();
        $election->winners()->sync([$winners->id => ['votes' => $winners->votes_count]]);

        $response = $this->actingAs($user, 'admin')->post(route('admin.elections.finalize-results', $election));
        $response->assertForbidden();
    }
}
