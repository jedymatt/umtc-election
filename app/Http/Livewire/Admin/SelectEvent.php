<?php

namespace App\Http\Livewire\Admin;

use App\Models\Event;
use Livewire\Component;

class SelectEvent extends Component
{
    public $selectedEvent;

    public $searchText = '';

    public $events;

    protected $listeners = [
        'eventSelected' => 'selectEvent',
    ];

    public function mount()
    {
        $this->selectedEvent = null;
        $this->events = Event::select('id', 'title')->get();
    }

    public function updatingSearchText()
    {
        $this->events = Event::where('title', 'like', '%'.$this->searchText.'%')->get();
    }

    public function selectEvent(Event $event)
    {
        if ($this->selectedEvent?->id === $event->id) {
            return;
        }

        $this->selectedEvent = $event;
        $this->refresh();

        $this->emitUp('eventSelected', ['event' => $event->id]);
    }

    public function refresh()
    {
        $this->searchText = '';
        $this->events = $this->searchText === '' ? Event::all() : Event::where('title', 'like', '%'.$this->searchText.'%')->get();
    }

    public function render()
    {
        return view('livewire.admin.select-event');
    }
}
