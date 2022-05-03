<?php

namespace App\Http\Livewire\Admin\MonitorElection;

use App\Models\Election;
use App\Models\User;
use Livewire\Component;

class ShowCandidates extends Component
{
    public $election;
    public $positions;
    public $candidates;

    public function mount(Election $election)
    {
        $this->election->loadMissing('electionType', 'electionType.positions');
        $this->election = $election;
        $this->positions = $election->electionType->positions;
        $this->candidates = $this->queryCandidates();
    }

    public function render()
    {
        return view('livewire.admin.monitor-election.show-candidates');
    }

    public function refreshCandidates()
    {
        $this->candidates = $this->queryCandidates();
    }

    public function queryCandidates()
    {
        return $this->election->candidates()
            ->select('position_id', 'user_id')
            ->with(['user:id,department_id,name', 'user.department:id,name'])
            ->withCount('votes')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();
    }
}
