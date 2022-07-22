<?php

namespace App\Http\Controllers;

use App\Events\VoteSubmitted;
use App\Http\Requests\StoreElectionVoteRequest;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use App\Services\ElectionService;

class ElectionVoteController extends Controller
{
    public function create(Election $election)
    {
        $canVote = ElectionService::canVote($election, auth()->user());

        abort_if(! $canVote, 403);

        $candidates = $election->candidates()
            ->with(['election', 'position', 'user'])
            ->orderBy('position_id')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();

        $candidatesByPositionName = $candidates->groupBy('position.name');

        return view('elections.vote', compact(
            'election',
            'candidatesByPositionName'
        ));
    }

    public function store(StoreElectionVoteRequest $request, Election $election)
    {
        $validated = $request->validated();
        $vote = Vote::create([
            'user_id' => $request->user()->id,
            'election_id' => $election->id,
        ]);

        if (array_key_exists('candidates', $validated)) {
            $vote->candidates()->sync($validated['candidates']);
        }

        event(new VoteSubmitted($election));

        return redirect()->route('elections.index')
            ->with('success', 'Vote submitted successfully');
    }
}
