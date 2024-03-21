<?php

namespace App\Livewire\Admin\Election;

use App\Models\Election;
use App\Models\User;
use Livewire\Component;

class ShowLiveResult extends Component
{
    public $election;

    public function mount(Election $election)
    {
        $this->election = $election;
    }

    public function render()
    {
        return view('livewire.admin.election.show-live-result', [
            'candidates' => $this->queryCandidates(),
        ]);
    }

    public function queryCandidates()
    {
        return $this->election->candidates()
            ->select(['position_id', 'user_id'])
            ->with(['user.department', 'position'])
            ->withCount('votes')
            ->orderBy('position_id')
            ->orderBy(User::select('name')->whereColumn('candidates.user_id', 'users.id'))
            ->get()
            ->groupBy('position.name')
            ->toBase();
    }
}
