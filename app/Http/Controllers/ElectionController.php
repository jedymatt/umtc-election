<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\User;
use App\Services\ElectionService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ElectionController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->department_id !== null) {
            $availableElections = ElectionService::getVotableElectionsFromUser($user);
            $votedElections = ElectionService::getVotedElectionsFromUser($user);
            $pastElections = ElectionService::pastElectionsByUser($user);
            $hasPendingWinners = $pastElections->map(function (Election $election) {
                return $election->hasNoWinners() || $election->hasConflictedWinners();
            });
        } else {
            $availableElections = EloquentCollection::empty();
            $votedElections = EloquentCollection::empty();
            $pastElections = EloquentCollection::empty();
            $hasPendingWinners = EloquentCollection::empty();
        }

        return view('elections.index', [
            'availableElections' => $availableElections,
            'votedElections' => $votedElections,
            'pastElections' => $pastElections,
            'hasPendingWinners' => $hasPendingWinners,
            'userHasNoDepartment' => $user->department_id === null,
        ]);
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
