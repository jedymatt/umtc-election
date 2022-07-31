<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use App\Models\ElectionType;
use App\Models\Event;
use App\Services\ElectionService;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateElectionForm extends Component
{
    public $currentEvent;
    public $currentElectionTypeId;
    public $electionTypes;
    public $departments;

    public $form = [
        'title' => '',
        'description' => '',
        'start_at' => '',
        'end_at' => '',
        'department_id' => ''
    ];

    protected $listeners = [
        'eventSelected' => 'updateCurrentEvent',
    ];

    public function mount()
    {
        $this->currentElectionTypeId = null;
        $this->departments = Department::all();
        $this->electionTypes = ElectionType::all();
    }

    public function updateCurrentEvent(Event $event): void
    {
        $this->currentEvent = $event;
    }

    public function updateCurrentElectionType(ElectionType $electionType): void
    {
        $this->currentElectionTypeId = $electionType;
    }


    public function createElection(): void
    {
        if ((int)$this->currentElectionTypeId === ElectionType::TYPE_DSG) {
            $this->createDsgElection();
        } else {
            $this->createCdsgElection();
        }
    }

    public function createDsgElection(): void
    {
        Validator::make($this->form, [
            'title' => 'required|string|unique:elections',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
            'department_id' => 'required|integer'
        ])->validate();

        ElectionService::createDsgElection(
            array_merge($this->form, [
                'event_id' => $this->currentEvent->id,
            ])
        );
    }

    public function createCdsgElection()
    {
        // code...
    }


    public function render()
    {
        return view('livewire.admin.create-election-form');
    }
}
