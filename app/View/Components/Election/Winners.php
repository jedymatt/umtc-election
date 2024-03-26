<?php

namespace App\View\Components\Election;

use App\Models\Election;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Winners extends Component
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
        $candidates = $this->election->winners()
            ->with('user.department')
            ->withCount('votes')
            ->orderBy('position_id')
            ->get();

        return view('components.election.winners', [
            'winners' => $candidates,
        ]);
    }
}
