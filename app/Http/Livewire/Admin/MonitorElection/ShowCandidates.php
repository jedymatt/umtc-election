<?php

namespace App\Http\Livewire\Admin\MonitorElection;

use App\Models\Election;
use App\Models\User;
use Livewire\Component;

class ShowCandidates extends Component
{
    public $election;

    public $candidates;

    public function mount(Election $election)
    {
        $this->election = $election;
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

    public function getListeners()
    {
        return [
            "echo-private:election.{$this->election->id},VoteSubmitted" => 'refreshCandidates',
        ];
    }

    public function queryCandidates()
    {
        return $this->election->candidates()
            ->select(['position_id', 'user_id'])
            ->with(['user:id,department_id,name', 'user.department:id,name', 'position:id,name'])
            ->withCount('votes')
            ->orderBy('position_id')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get()
            ->groupBy('position.name')
            ->toBase();
    }
}
