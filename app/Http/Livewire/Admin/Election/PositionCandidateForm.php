<?php

namespace App\Http\Livewire\Admin\Election;

use App\Models\User;
use Livewire\Component;

class PositionCandidateForm extends Component
{
    public $position;
    public $search;
    public $result;
    public $candidates;
    public $election;
    public $users;

    public function mount()
    {
        $this->search = '';
        $this->result = [];
        $this->candidates = [];
        $this->users = null;
    }


    public function render()
    {
        return view('livewire.admin.election.position-candidate-form');
    }


    public function searchUsers()
    {
        if (empty($this->search)) {
            $this->users = null;
            return;
        }

        $this->users = User::search($this->search)->paginate(3)->items();
    }
}
