<?php

namespace App\Http\Livewire\Admin\Election\Candidate;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public Election $election;
    public $position;
    public $search = '';
    public $candidates;
    public $users = [];
    public $candidateUserIds = [];

    public function mount()
    {
        $this->candidates = $this->election->candidates()
            ->wherePositionId($this->position->id)
            ->with('user')
            ->get();

        foreach ($this->candidates as $candidate) {
            $this->candidateUserIds[] = $candidate->user_id;
        }
    }

    public function render()
    {
        return view('livewire.admin.election.candidate.create');
    }

    public function searchUsers()
    {
        if ($this->search == '') {
            $this->users = [];
            return;
        }
        $this->users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->whereNotIn('id', $this->candidateUserIds)
            ->limit(3)
            ->orderByDesc('id')
            ->get();
    }

    public function addUserToCandidates(User $user) {
        $this->search = '';
        $this->users = [];
        $candidate = Candidate::create([
            'user_id' => $user->id,
            'position_id' => $this->position->id,
            'election_id' => $this->election->id,
        ]);

        $this->candidates[] = $candidate;
    }

    public function removeCandidate(Candidate $candidate) {
        $candidate->delete();

        $this->candidates = $this->election->candidates()
            ->wherePositionId($this->position->id)
            ->with('user')
            ->get();

        foreach ($this->candidates as $candidate) {
            $this->candidateUserIds[] = $candidate->user_id;
        }
    }

}
