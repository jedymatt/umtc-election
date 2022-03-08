<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElectionVoteController extends Controller
{
    public function create(Election $election)
    {
        $positions = $election->electionType->positions;

        $candidates = $election->candidates()
            ->with(['election', 'position', 'user'])
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();

        return view('elections.vote.create', compact(
            'election', 'positions', 'candidates'
        ));
    }

    public function store(Request $request, Election $election)
    {
        // TODO: Validate election
        $vote = Vote::create([
            'user_id' => $request->user()->id,
            'election_id' => $election->id,
        ]);

        $vote->candidates()->sync($request->input('candidates'));

        return response()->json($vote->candidates); // TODO: Redirect to proper route
    }
}
