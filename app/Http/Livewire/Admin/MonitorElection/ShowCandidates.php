<?php

namespace App\Http\Livewire\Admin\MonitorElection;

use App\Models\Election;
use App\Models\User;
use Livewire\Component;

class ShowCandidates extends Component
{
    public $election;

    public function mount(Election $election)
    {
        $this->election = $election;
    }

    public function render()
    {
        $this->election->loadMissing('electionType', 'electionType.positions');
        $positions = $this->election->electionType->positions;
        $candidates = $this->election->candidates()
            ->with(['position', 'user', 'user.department'])
            ->withCount('votes')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();
        return view('livewire.admin.monitor-election.show-candidates',
            compact('positions', 'candidates'),
        );
    }
}
