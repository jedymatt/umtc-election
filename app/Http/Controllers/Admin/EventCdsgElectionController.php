<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCdsgElectionRequest;
use App\Models\Admin;
use App\Models\Event;
use App\Services\ElectionService;
use App\Services\EventService;

class EventCdsgElectionController extends Controller
{
    protected $electionService;

    public function __construct(ElectionService $electionService)
    {
        $this->electionService = $electionService;
    }

    public function create(Event $event)
    {
        /** @var Admin $admin */
        $admin = auth('admin')->user();

        abort_if(! empty(EventService::createCdsgElectionFailureMessage($event, $admin)), 403, 'Cannot create election');

        return view('admin.events.cdsg-elections.create', compact('event'));
    }

    public function store(StoreCdsgElectionRequest $request, Event $event)
    {
        $validated = $request->validated();

        $election = $this->electionService->createCdsgElection([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'event_id' => $event->id,
        ]);

        return redirect()->route('admin.elections.candidates', $election)
            ->with('success', 'CDSG election successfully created!');
    }
}
