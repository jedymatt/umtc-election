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
        $positions = Position::ofElectionType($election->electionType)->get();
        $candidates = $election->candidates()
            ->with(['position', 'user'])
            ->withCount('votes')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();

        // TODO: Replace calculated to conflicted winners
        $calculatedWinners = $election->isEnded() ? (new ElectionService($election))->getPreWinners()
            : collect();

        $winners = $election->winners()
            ->with(['candidate'])
            ->orderBy(Candidate::select('position_id')
                ->whereColumn('winners.candidate_id', '=', 'candidates.id'))
            ->get();

        return view('admin.monitor-election', compact(
            'election', 'positions', 'candidates', 'calculatedWinners', 'winners'
        ));
    }
}
