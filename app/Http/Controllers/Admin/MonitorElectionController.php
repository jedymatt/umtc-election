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

        if ($election->isEnded() && $election->winners()->doesntExist()) {
            (new ElectionService($election))->saveWinners();
        }

        return view('admin.monitor-election', compact(
            'election',
        ));
    }
}
