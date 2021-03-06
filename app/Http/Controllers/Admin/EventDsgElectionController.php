<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDsgElectionRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Event;
use App\Services\ElectionService;
use App\Services\EventService;

class EventDsgElectionController extends Controller
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

        abort_if(! empty(EventService::createDsgElectionFailureMessage($event, $admin)), 403, 'Cannot create election');

        $occupiedDepartments = $event->dsgElections->map(function ($election) {
            return $election->department_id;
        })->filter();

        if ($admin->is_super_admin) {
            $departments = Department::orderBy('name')
                ->whereNotIn('id', $occupiedDepartments)->get();
        } else {
            $departments = $occupiedDepartments->contains($admin->department_id) ? collect() : collect([$admin->department]);
        }

        return view('admin.events.dsg-elections.create', compact('event', 'departments'));
    }

    public function store(StoreDsgElectionRequest $request, Event $event)
    {
        $validated = $request->validated();

        $election = $this->electionService->createDsgElection([
            'event_id' => $event->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'department_id' => $validated['department_id'],
        ]);

        $election->candidates()->createMany($validated['candidates'] ?? []);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'DSG election successfully created!');
    }
}
