<?php

namespace App\Http\Livewire\Admin\Elections;

use App\Models\Election;
use App\Models\Winner;
use App\Services\ElectionService;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ShowWinners extends Component
{
    private $electionService;

    public Election $election;

    public $winners;

    public $winnersConflicts;

    /**
     * @var array<Winner>
     */
    public array $selectedWinners = [];

    public $showWinners;

    public function mount(Election $election)
    {
        $this->election = $election;

        $this->electionService = new ElectionService($election);

        $this->winners = $election->winners()->with([
            'candidate',
            'candidate.position',
            'candidate.user',
            'candidate.user.department',
            'election',
        ])->get();

        $this->showWinners = $this->electionService->hasWinnersConflict();

        $this->winnersConflicts = $this->showWinners ? $this->electionService->getWinnersConflicts() : [];
    }

    public function render()
    {
        return view('livewire.admin.elections.show-winners');
    }


    public function resolveConflict()
    {
        foreach ($this->selectedWinners as $positionId => $winnerId) {
            $this->election->winners()
                ->whereHas('candidate', function (Builder $query) use ($positionId, $winnerId) {
                    $query->where('position_id', '=', $positionId);
                })
                ->where('id', '!=', $winnerId)->delete();
        }

        // Temporary fix by refreshing the page
        return redirect()->refresh();
    }
}
