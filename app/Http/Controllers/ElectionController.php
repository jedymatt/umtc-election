<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionType;
use App\Services\ElectionService;
use function view;

class ElectionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $activeElections = Election::with(['department', 'electionType'])
            ->active();
        $endedElections = Election::ended();

        if ($user->department_id == null) {
            $activeElections = $activeElections->where('election_type_id', ElectionType::TYPE_CDSG)
                ->get();


            $endedElections = $endedElections->orWhere('election_type_id', ElectionType::TYPE_CDSG)
                ->get();
        } else {
            $department = $user->department;

            $activeElections = $activeElections
                ->ofDepartment($department)
                ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
                ->get();

            $endedElections = $endedElections
                ->ofDepartment($department)
                ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
                ->get();
        }

        $isEmptyWinners = [];

        foreach ($endedElections as $election) {
            $isEmptyWinners[$election->id] = $election->winners()->doesntExist()
                || (new ElectionService($election))->hasWinnersConflict();
        }

        return view('elections.index', compact('activeElections', 'endedElections', 'isEmptyWinners'));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
