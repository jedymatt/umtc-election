<?php

namespace App\Http\Livewire\Admin\Elections;

use App\Models\Election;
use App\Services\ElectionService;
use Livewire\Component;

class ShowWinners extends Component
{
    public $winners;
    public $hasWinnersConflict;
    public $winnersConflicts;

    private $electionService;

    public function mount(Election $election)
    {
        $this->electionService = new ElectionService($election);

        $this->winners = $election->winners;

        $this->hasWinnersConflict = $this->electionService->hasWinnersConflict();

        $this->winnersConflicts = $this->hasWinnersConflict ? $this->electionService->getWinningCandidatesConflicts() : collect();
    }

    public function render()
    {
        return view('livewire.admin.elections.show-winners');
    }
}
