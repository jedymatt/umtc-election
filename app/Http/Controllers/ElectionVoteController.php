<?php

namespace App\Http\Controllers;

use App\Events\VoteSubmitted;
use App\Http\Requests\StoreElectionVoteRequest;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use App\Services\ElectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function redirect;
use function view;

class ElectionVoteController extends Controller
{
    public function create(Election $election)
    {
        $canVote = ElectionService::canVote($election, auth()->user());

        abort_if(!$canVote, 403);

        $positions = $election->electionType->positions()->orderBy('id')->get();

        $candidates = $election->candidates()
            ->with(['election', 'position', 'user'])
            ->orderBy('position_id')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();

        return view('elections.vote', compact(
            'election',
            'positions',
            'candidates'
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
