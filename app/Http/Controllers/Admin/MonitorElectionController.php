<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Services\ElectionService;

class MonitorElectionController extends Controller
{
    public function show(Election $election)
    {
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

        $conflictedWinners = ElectionService::getWinnersConflicts($winners);

        return view('admin.monitor-election')
            ->with('election', $election)
            ->with('isPendingResult', $isPendingResult)
            ->with('conflictedWinners', $conflictedWinners)
            ->with('winners', $winners);
    }
}
