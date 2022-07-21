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

        $isCompleteUserInfo = $user->department_id != null;

        $activeElections = $isCompleteUserInfo ? ElectionService::activeElectionsByUser($user) : [];
        $pastElections = $isCompleteUserInfo ? ElectionService::pastElectionsByUser($user) : [];

        $isPendingWinners = [];

        foreach ($pastElections as $election) {
            $isPendingWinners[$election->id] = $election->winners()->doesntExist()
                || $election->hasConflictedWinners();
        }

        $userCanVoteActiveElections = [];

        foreach ($activeElections as $election) {
            $userCanVoteActiveElections[$election->id] = ElectionService::canVote($election, auth()->user());
        }

        return view('elections.index', compact(
            'activeElections',
            'pastElections',
            'isPendingWinners',
            'userCanVoteActiveElections',
            'isCompleteUserInfo',
        ));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
