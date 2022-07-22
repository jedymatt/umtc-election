<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Services\ElectionService;

class MonitorElectionController extends Controller
{
    public function show(Election $election)
    {
        $election->loadMissing('electionType');

        $isPendingResult = $election->isEnded()
            && $election->candidates()->exists()
            && $election->winners()->doesntExist();

        $winners = $election->winners()->with([
            'candidate',
            'candidate.position',
            'candidate.user',
            'candidate.user.department',
            'election',
        ])->get();

        $conflictedWinners = $election->hasConflictedWinners() ?
            (new ElectionService($election))->getWinnersConflicts()
            : [];

        return view('admin.monitor-election', compact(
            'election',
            'isPendingResult',
            'conflictedWinners',
            'winners'
        ));
    }
}
