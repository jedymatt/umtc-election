<?php

namespace App\Http\Livewire\Admin;

use App\Models\Election;
use App\Models\Event;
use Livewire\Component;

class ShowElections extends Component
{
    public $currentEvent;

    public $events;

    public $elections;

    protected $listeners = [
        'eventSelected' => 'updateCurrentEvent',
    ];

    public function mount()
    {
        $this->currentEvent = Event::orderByDesc('created_at')->first();

        $this->events = Event::select('id', 'title')
            ->get();

        $this->elections = $this->getElectionsFromCurrentEvent();
    }

    protected function getElectionsFromCurrentEvent()
    {
        return Election::with(['electionType', 'department'])
            ->where('event_id', $this->currentEvent->id)
            ->get();
    }

    public function updateCurrentEvent(Event $event)
    {
        $this->currentEvent = $event;
        $this->elections = $this->getElectionsFromCurrentEvent();
    }

    public function render()
    {
        return view('livewire.admin.show-elections');
    }
}
