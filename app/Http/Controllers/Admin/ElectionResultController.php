<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ElectionResultController extends Controller
{
    public function __invoke(Election $election)
    {

        return view('admin.elections.result', [
            'election' => $election,
            'hasNoWinners' => $election->winners()->doesntExist(),
            'tiedCandidates' => $election->candidates()
                ->withCount('votes')
                ->get()
                ->groupBy('position.name')
                ->sortKeys()
                ->map(fn (EloquentCollection $candidates) => $candidates->sortByDesc('votes_count'))
                ->map(fn (EloquentCollection $candidates) => $candidates->filter(function ($candidate) use ($candidates) {
                    $maxVotes = $candidates->max('votes_count');

                    return $candidate->votes_count === $maxVotes;
                }))
                ->filter(fn (EloquentCollection $candidates) => $candidates->count() > 1),
        ]);
    }
}
