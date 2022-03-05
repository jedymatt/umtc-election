<?php

namespace App\Http\Livewire\Admin\Election;

use App\Models\Department;
use App\Models\ElectionType;
use Livewire\Component;

class Create extends Component
{

    public $electionTypes;
    public $departments;
    public $electionTypeId;
    public $showDepartments;

    public function mount()
    {
        $this->electionTypes = ElectionType::all();
        $this->departments = Department::orderBy('name')->get();
        $this->showDepartments = $this->electionTypes->first()->id == 1;
    }

    public function render()
    {
        return view('livewire.admin.election.create');
    }

    public function onChangeElectionType() {
        $this->showDepartments = $this->electionTypeId == 1;
    }
}
