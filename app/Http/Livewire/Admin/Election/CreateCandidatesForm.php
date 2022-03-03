<?php

namespace App\Http\Livewire\Admin\Election;

use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateCandidatesForm extends Component
{
    /**
     * @\App\Models\Election
     */
    public $election;
    public $candidates;
    public $positions;

    public function mount()
    {
        $this->candidates = collect();
        $this->positions = $this->election->positions;
    }

    public function render()
    {
        return view('livewire.admin.election.create-candidates-form');
    }
}
