<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Auth;

class ElectionVoteController extends Controller
{
    public function create(Request $request, Election $election)
    {
        $user = $request->user();

        $hasVote = Vote::where('election_id', $election->id)
            ->where('user_id', $user->id)
            ->exists();

        abort_if($hasVote, 403);

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
        $user = $request->user();

        $hasVote = Vote::where('election_id', $election->id)
            ->where('user_id', $user->id)
            ->exists();

        abort_if($hasVote, 403);

        $validator = Validator::make($request->all(), [
            'candidates.*' => 'required|integer',
        ]);

        $validated = $validator->validated();
        
        $vote = Vote::create([
            'user_id' => $user->id,
            'election_id' => $election->id,
        ]);

        if (array_key_exists('candidates', $validated)) {
            $vote->candidates()->sync($validated['candidates']);
        }

        return redirect()->route('elections.index');
    }
}
