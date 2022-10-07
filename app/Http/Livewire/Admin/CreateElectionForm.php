<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use App\Models\ElectionType;
use App\Models\Event;
use App\Services\ElectionService;
use App\Services\EventService;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateElectionForm extends Component
{
    public int $currentElectionTypeId;

    public ?Event $currentEvent;

    public $electionTypes;

    public $departments;

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
        $this->departments = [];
    }

    public function updateCurrentEvent(Event $event): void
    {
        $this->currentEvent = $event;

        $availableDepartments = Department::orderBy('name')->doesntHaveDsgElectionOfEvent($event)->get();
        $this->departments = auth()->user()->is_super_admin ? $availableDepartments : $availableDepartments->where('id', auth()->user()->department_id);
    }

    public function createElection()
    {
        if ($this->currentElectionTypeId === ElectionType::TYPE_DSG) {
            $failureMessage = EventService::createDsgElectionFailureMessage($this->currentEvent, auth('admin')->user());
        } else {
            $failureMessage = EventService::createCdsgElectionFailureMessage($this->currentEvent, auth('admin')->user());
        }

        if (! empty($failureMessage)) {
            $this->dispatchBrowserEvent('toast-alert', [
                'type' => 'error',
                'message' => $failureMessage,
            ]);

            return;
        }

        if ($this->currentElectionTypeId === ElectionType::TYPE_DSG) {
            $election = $this->createDsgElection();
        } else {
            $election = $this->createCdsgElection();
        }

        return $this->redirect(route('admin.elections.candidates', $election));
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
