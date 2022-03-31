<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use App\Services\ElectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function abort_if;
use function now;
use function redirect;
use function view;

class ElectionVoteController extends Controller
{
    public function create(Request $request, Election $election)
    {
        $canVote = (new ElectionService($election))->canVote($request->user());

        abort_unless($canVote, 403);

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
        $canVote = (new ElectionService($election))->canVote($request->user());

        abort_unless($canVote, 403);


        $validator = Validator::make($request->all(), [
            'candidates.*' => 'required|integer',
        ]);

        $validated = $validator->validated();

        $vote = Vote::create([
            'user_id' => $request->user()->id,
            'election_id' => $election->id,
        ]);

        if (array_key_exists('candidates', $validated)) {
            $vote->candidates()->sync($validated['candidates']);
        }

        return redirect()->route('elections.index');
    }
}
