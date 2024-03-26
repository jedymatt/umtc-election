<?php

namespace App\View\Components\Election;

use App\Models\Election;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Result extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private readonly Election $election)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $candidates = $this->election->candidates()
            ->with('user.department')
            ->withCount('votes')
            ->orderBy('position_id')
            ->orderBy(User::select('name')->whereColumn('id', 'candidates.user_id'))
            ->get();

        return view('components.election.result', [
            'candidates' => $candidates->groupBy('position.name'),
            'topVotedCandidates' => $candidates
                ->groupBy('position_id')
                ->sortKeys()
                ->map(fn (Collection $candidates) => $candidates->sortByDesc('votes_count'))
                ->map(
                    fn (Collection $candidates) => $candidates
                        ->filter(fn ($candidate) => $candidate->votes_count > 0)
                        ->filter(fn ($candidate) => $candidate->votes_count === $candidates->max('votes_count'))
                )
                ->flatten(),
        ]);
    }
}
