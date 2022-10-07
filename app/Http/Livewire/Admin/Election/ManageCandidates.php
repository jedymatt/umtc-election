<?php

namespace App\Http\Livewire\Admin\Election;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use Livewire\Component;

class ManageCandidates extends Component
{
    public $positions;

    public $selectedPositionId;

    public $candidates;

    public $election;

    public string $searchText = '';

    public $results = [];

    public bool $showResults = false;

    public function mount(Election $election)
    {
        $this->election = $election;
        $this->positions = Position::all(['id', 'name']);
        $this->candidates = $election->candidates;
        $this->selectedPositionId = $this->positions->first()->id;
    }

    public function render()
    {
        return view('livewire.admin.election.manage-candidates');
    }

    // when $searchText is updated, this method is called
    public function updatedSearchText()
    {
        $this->results = $this->searchText === '' ? [] : $this->search($this->searchText);
        $this->showResults = $this->searchText !== '' && count($this->results) > 0;
    }

    // search for users
    public function search(string $searchText)
    {
        return User::where('name', 'like', '%'.$searchText.'%')
            ->orWhere('email', 'like', '%'.$searchText.'%')
            ->limit(10)
            ->get(['id', 'name', 'email']);
    }

    public function selectUserFromResults(User $user)
    {
        $this->candidates->push($this->makeCandidate($user));
        $this->searchText = '';
        $this->results = [];
        $this->showResults = false;
    }

    public function makeCandidate(User $user): Candidate
    {
        return $this->election->candidates()->create([
            'user_id' => $user->id,
            'position_id' => $this->selectedPositionId,
        ]);
    }

    public function removeCandidate(Candidate $candidate) {
        $candidate->delete();
        $this->candidates = $this->candidates->filter(function ($c) use ($candidate) {
            return $c->id !== $candidate->id;
        });
    }
}
