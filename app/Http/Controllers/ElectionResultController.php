<?php

namespace App\Http\Controllers;

use App\Models\Election;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        abort_if(! $election->isEnded(), 403);

        abort_if(($election->winners()->doesntExist() || $election->hasConflictedWinners()), 403);

        $winners = $election->winners
            ->loadMissing('candidate.position', 'candidate.user', 'candidate.user.department');

        return view('elections.result', compact('winners'));
    }
}
