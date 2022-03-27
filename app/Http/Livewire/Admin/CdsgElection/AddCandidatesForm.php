<?php

namespace App\Http\Livewire\Admin\CdsgElection;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class AddCandidatesForm extends Component
{
    public Collection $candidates;
    public $election;
    public $positions;
    public $searchText = '';

    public $selectedPositionId = null;
    public $selectedUserId = null;


    public function mount(Election $election)
    {
        $this->positions = $election->electionType->positions;
        $this->selectedPositionId = $this->positions->first()->id;
        $this->candidates = collect();
    }

    public function render()
    {
        return view('livewire.admin.cdsg-election.add-candidates-form', [
            'users' => User::search($this->searchText)->paginate(5),
        ]);
    }


    public function addCandidate(User $user)
    {

        $this->candidates->prepend([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,

            'position_id' => $this->selectedPositionId,
            'position_name' => $this->positions->where('id', $this->selectedPositionId)->first()->name,

            'election_id' => $this->election->id,
        ]);
    }

    public function removeCandidate(array $candidate)
    {
        $this->candidates = $this->candidates->reject(function ($value, $key) use ($candidate) {
            return $value == $candidate;
        });
    }
}
