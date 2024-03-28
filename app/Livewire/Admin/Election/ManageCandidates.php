<?php

namespace App\Livewire\Admin\Election;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ManageCandidates extends Component
{
    #[Locked]
    public $positions;

    public $selectedPositionId;

    /** @var Collection<int, Candidate> */
    public Collection $candidates;

    #[Locked]
    public Election $election;

    public string $searchText = '';

    public $results = [];

    public bool $showResults = false;

    public function mount(Election $election): void
    {
        $this->election = $election;
        $this->positions = Position::all();
        $this->candidates = $election->candidates()
            ->orderBy('position_id')
            ->orderBy(User::select('name')->whereColumn('id', 'user_id'))
            ->get();
        $this->selectedPositionId = $this->positions->first()->id;
    }

    public function render(): View
    {
        return view('livewire.admin.election.manage-candidates');
    }

    // when $searchText is updated, this method is called
    public function updatedSearchText(): void
    {
        $this->results = $this->searchText === '' ? [] : $this->search($this->searchText);
        $this->showResults = $this->searchText !== '' && count($this->results) > 0;
    }

    /**
     * @return Collection<int, User>
     */
    public function search(string $searchText): Collection
    {
        return User::query()
            ->where('name', 'like', '%'.$searchText.'%')
            ->orWhere('email', 'like', '%'.$searchText.'%')
            ->limit(10)
            ->get(['id', 'name', 'email']);
    }

    public function selectUserFromResults(User $user): void
    {
        $this->makeCandidate($user);
        $this->refreshCandidates();
        $this->reset('searchText', 'results', 'showResults');
    }

    public function makeCandidate(User $user): Candidate
    {
        if ($this->election->isEnded()) {
            $this->dispatch('toast-alert',
                type: 'error',
                message: 'Cannot add candidate to ended election.'
            );

            return new Candidate();
        }

        return $this->election->candidates()->create([
            'user_id' => $user->id,
            'position_id' => $this->selectedPositionId,
        ]);
    }

    public function removeCandidate(Candidate $candidate): void
    {
        if ($this->election->isEnded()) {
            $this->dispatch('toast-alert',
                type: 'error',
                message: 'Cannot remove candidate from ended election.'
            );

            return;
        }

        $candidate->delete();
        $this->refreshCandidates();
    }

    public function refreshCandidates(): void
    {
        $this->candidates = $this->election->candidates()
            ->orderBy('position_id')
            ->orderBy(User::select('name')->whereColumn('id', 'user_id'))
            ->get();
    }
}
