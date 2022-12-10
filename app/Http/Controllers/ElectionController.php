<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use App\Services\ElectionService;

class ElectionController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $availableElections = ElectionService::getVotableElectionsFromUser($user);
        $votedElections = ElectionService::getVotedElectionsFromUser($user);
        $pastElections = ElectionService::pastElectionsByUser($user);
        $hasPendingWinners = $pastElections->map(function (Election $election) {
            return $election->hasNoWinners() || $election->hasConflictedWinners();
        });

        return view('elections.index')
            ->with('availableElections', $availableElections)
            ->with('votedElections', $votedElections)
            ->with('pastElections', $pastElections)
            ->with('hasPendingWinners', $hasPendingWinners)
            ->with('userHasNoDepartment', $user->department_id === null);
    }

    public function show(Election $election)
    {
        return view('elections.show')
            ->with('election', $election);
    }
}
