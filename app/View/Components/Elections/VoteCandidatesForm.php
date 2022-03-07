<?php

namespace App\View\Components\Elections;

use App\Models\Election;
use App\Models\Position;
use Illuminate\View\Component;

class VoteCandidatesForm extends Component
{
    public $candidates;
    public $position;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Election $election, Position $position)
    {
        $this->position = $position;
        $this->candidates = $election->candidates()
            ->wherePositionId($position->id)
            ->with('user')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.elections.vote-candidates-form');
    }
}
