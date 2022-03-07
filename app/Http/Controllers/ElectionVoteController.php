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

        $candidates = $election->candidates()->with(['election', 'position', 'user'])
            ->orderBy(User::select('name')->where('id', 'candidates.user_id'))
            ->get();
        return view('elections.vote', compact(
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

        $vote->candidates()->sync($request->input('positions.*'));

        return redirect()->back(); // TODO: Redirect to proper route
    }
}
