<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Services\ElectionService;
use Illuminate\Database\Eloquent\Builder;
use function view;

class ElectionController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $activeElections = Election::with(['department', 'electionType']);

        $endedElections = Election::query();

        if ($user->department_id == null) {
            $activeElections = [];
            $endedElections = [];
        } else {
            $department = $user->department;

            $activeElections = $activeElections
                ->orWhere(function (Builder $query) {
                    $query->active()
                        ->where('election_type_id', ElectionType::TYPE_DSG)
                        ->where('department_id', auth()->user()->department_id);
                })
                ->orWhere(function (Builder $query) {
                    $query->active()
                        ->where('election_type_id', ElectionType::TYPE_CDSG)
                        ->whereRelation('event.elections.winners.candidate', 'user_id', '=', auth()->id());
                })
                ->get();

            $endedElections = $endedElections
                ->orWhere(function (Builder $query) {
                    $query->ended()
                        ->where('department_id', '=', auth()->user()->department_id);
                })
                ->orWhere(function (Builder $query) {
                    $query->ended()
                        ->where('election_type_id', ElectionType::TYPE_CDSG);
                })
                ->get();
        }

        $isEmptyWinners = [];

        foreach ($endedElections as $election) {
            $isEmptyWinners[$election->id] = $election->winners()->doesntExist()
                || (new ElectionService($election))->hasWinnersConflict();
        }

        $userCanVoteActiveElections = [];

        foreach ($activeElections as $election) {
            $userCanVoteActiveElections[$election->id] = ElectionService::canVote($election, auth()->user());
        }

        return view('elections.index', compact('activeElections', 'endedElections', 'isEmptyWinners', 'userCanVoteActiveElections'));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
