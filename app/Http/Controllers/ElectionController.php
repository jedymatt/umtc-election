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

        $isCompleteUserInfo = $user->department_id !== null;

        $availableElections = $isCompleteUserInfo ? ElectionService::getVotableElectionsFromUser($user) : [];
        $votedElections = $isCompleteUserInfo ? ElectionService::getVotedElectionsFromUser($user) : [];

        $pastElections = $isCompleteUserInfo ? ElectionService::pastElectionsByUser($user) : [];

        $isPendingWinners = [];

        foreach ($pastElections as $election) {
            $isPendingWinners[$election->id] = $election->winners()->doesntExist()
                || $election->hasConflictedWinners();
        }

        return view('elections.index', compact(
            'pastElections',
            'isPendingWinners',
            'isCompleteUserInfo',
            'availableElections',
            'votedElections'
        ));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
