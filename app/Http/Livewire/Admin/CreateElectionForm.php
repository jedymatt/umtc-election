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
    public int $currentElectionTypeId;

    public Event $currentEvent;

    public $electionTypes;

    public $departments;

    public bool $showDepartmentsOption = true;

    public $form = [
        'title' => '',
        'description' => '',
        'start_at' => '',
        'end_at' => '',
        'department_id' => '',
    ];

    protected $listeners = [
        'eventSelected' => 'updateCurrentEvent',
    ];

    public function mount()
    {
        $this->electionTypes = ElectionType::all();
        $this->currentElectionTypeId = ElectionType::TYPE_DSG;
        $this->departments = Department::all();
    }

    public function updateCurrentEvent(Event $event): void
    {
        $this->currentEvent = $event;
    }

    public function changeElectionType(): void
    {
        // $this->currentElectionTypeId = $electionType;
        $this->showDepartmentsOption = $this->currentElectionTypeId === ElectionType::TYPE_DSG;
    }

    public function createElection()
    {
        if ($this->currentElectionTypeId === ElectionType::TYPE_DSG) {
            $election = $this->createDsgElection();
        } else {
            $election = $this->createCdsgElection();
        }

        return $this->redirect(route('admin.elections.show', $election));
    }

    public function createDsgElection()
    {
        Validator::make($this->form, [
            'title' => 'required|string|unique:elections',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
            'department_id' => 'required|integer',
        ])->validate();

        return ElectionService::createDsgElection(
            array_merge($this->form, [
                'event_id' => $this->currentEvent->id,
            ])
        );
    }

    public function createCdsgElection()
    {
        Validator::make($this->form, [
            'title' => 'required|string|unique:elections',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
        ])->validate();

        return ElectionService::createCdsgElection(
            array_merge($this->form, [
                'event_id' => $this->currentEvent->id,
            ])
        );
    }

    public function render()
    {
        return view('livewire.admin.create-election-form');
    }
}
