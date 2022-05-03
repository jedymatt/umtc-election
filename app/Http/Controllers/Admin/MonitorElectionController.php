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

        return view('admin.monitor-election', compact(
            'election',
        ));
    }
}
