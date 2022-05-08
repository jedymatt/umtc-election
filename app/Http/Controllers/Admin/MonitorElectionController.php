<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use App\Services\ElectionService;
use Illuminate\Http\Request;

class MonitorElectionController extends Controller
{
    public function show(Election $election)
    {
        $election->loadMissing('electionType', 'electionType.positions');

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
            'election', 'isPendingResult', 'conflictedWinners', 'winners'
        ));
    }
}
