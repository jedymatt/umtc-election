<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use function view;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        abort_unless($election->isEnded(), 403);

        $positions = Position::ofElectionType($election->electionType)->get();
        $candidates = $election->candidates()
            ->with(['position', 'user'])
            ->withCount('votes')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();

        return view('elections.result.show', compact('election', 'candidates', 'positions'));
    }
}
