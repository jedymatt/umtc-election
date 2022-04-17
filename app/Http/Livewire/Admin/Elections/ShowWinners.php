<?php

namespace App\Http\Livewire\Admin\Elections;

use App\Models\Election;
use App\Services\ElectionService;
use Livewire\Component;

class ShowWinners extends Component
{
    public Election $election;
    public $winners;
    public bool $showWinners;
    public $winnersConflicts;

    public function mount(Election $election)
    {
        $this->election = $election;

        $electionService = new ElectionService($election);

        $this->winners = $election->winners()->with([
            'candidate',
            'candidate.position',
            'candidate.user',
            'candidate.user.department',
            'election',
        ])->get();

        $this->showWinners = $electionService->hasWinnersConflict();

        $this->winnersConflicts = $this->showWinners ? $electionService->getWinnersConflicts() : collect();
    }

    public function render()
    {
        return view('livewire.admin.elections.show-winners');
    }
}
