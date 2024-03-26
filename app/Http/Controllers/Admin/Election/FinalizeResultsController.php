<?php

namespace App\Http\Controllers\Admin\Election;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FinalizeResultsController extends Controller
{
    public function __invoke(Request $request, Election $election)
    {
        if ($election->end_at->isFuture()) {
            abort(403, 'The election is not yet ended.');
        }

        $candidates = $election->candidates()->withCount('votes')->get();

        /** @var SupportCollection<int, EloquentCollection<int, Candidate>> $topVotedCandidates */
        $topVotedCandidates = $candidates
            ->groupBy('position_id')
            ->sortKeys()
            ->map(fn (EloquentCollection $candidates) => $candidates->sortByDesc('votes_count'))
            ->map(fn (EloquentCollection $candidates) => $candidates->filter(function ($candidate) use ($candidates) {
                $maxVotes = $candidates->max('votes_count');

                return $candidate->votes_count === $maxVotes;
            }));

        $tiedCandidates = $topVotedCandidates->filter(fn (EloquentCollection $candidates) => $candidates->count() > 1);

        if ($tiedCandidates->isNotEmpty()) {
            $validated = $request->validate([
                'candidates' => ['required', 'array', 'size:'.$tiedCandidates->keys()->count()],
                'candidates.*' => [
                    'required',
                    'integer',
                    Rule::in($candidates->pluck('id')->toArray()),
                ],
            ]);

            $tiedCandidatePositions = $tiedCandidates->keys();
            $selectedCandidatePositions = Candidate::findMany($validated['candidates'])->pluck('position_id')->unique();
            if ($tiedCandidatePositions->diff($selectedCandidatePositions)->isNotEmpty()) {
                throw ValidationException::withMessages(
                    ['candidates' => 'Please select one candidate from each tied position.']
                );
            }
        }

        $winners = $topVotedCandidates->map(fn (EloquentCollection $candidates) => $candidates->first());

        $election->winners()->sync($winners->map(fn (Candidate $candidate) => [
            'candidate_id' => $candidate->id,
            'votes' => $candidate->votes_count,
        ]));

        return redirect()->route('admin.elections.result', $election)
            ->with('success', 'Winners have been declared.');
    }
}
