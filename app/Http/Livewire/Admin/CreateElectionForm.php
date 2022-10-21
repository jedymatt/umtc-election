<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use App\Models\ElectionType;
use App\Services\ElectionService;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateElectionForm extends Component
{
    public int $currentElectionTypeId;

    public $electionTypes;

    public $departments;

    public $form = [
        'title' => '',
        'description' => '',
        'start_at' => '',
        'end_at' => '',
        'department_id' => '',
    ];

    public function mount()
    {
        $this->electionTypes = ElectionType::all();
        $this->currentElectionTypeId = ElectionType::TYPE_DSG;
        $this->departments = Department::orderBy('name')->get();

        $this->form['department_id'] = strval($this->departments->first()->id);
    }

    public function createElection()
    {
        Validator::validate($this->form, [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'department_id' => 'required_if:election_type_id,'.ElectionType::TYPE_CDSG,
        ]);

        $election = $this->currentElectionTypeId == ElectionType::TYPE_DSG
            ? ElectionService::createDsgElection($this->form)
            : ElectionService::createCdsgElection($this->form);

        $this->redirect(route('admin.elections.candidates', $election));
    }

    public function render()
    {
        return view('livewire.admin.create-election-form');
    }
}
