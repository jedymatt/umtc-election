<?php

namespace App\Http\Livewire\Admin\CdsgElection;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AddCandidatesForm extends Component
{
    public $candidates;
    public $election;
    public $positions;
    public $searchText = '';

    public $selectedPositionId = null;
    public $selectedUserId = null;


    public function mount(Election $election)
    {
        $this->positions = $election->electionType->positions;

        $this->candidates = collect();
    }

    public function render()
    {
        return view('livewire.admin.cdsg-election.add-candidates-form', [
            'users' => User::search($this->searchText)->paginate(5),
        ]);
    }


    public function addCandidate()
    {
        if (empty($this->selectedUserId) || empty($this->selectedPositionId)) {
            return;
        }

        array_unshift($this->candidates, [
            'user_id' => $this->selectedUserId,
            'position_id' => $this->selectedPositionId,
            'election_id' => $this->selectedUserId,
        ]);
    }
}
