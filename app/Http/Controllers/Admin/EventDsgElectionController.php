<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventDsgElectionController extends Controller
{
    public function create(Event $event)
    {
        /** @var Admin $admin */
        $admin = auth('admin')->user();

        abort_unless(EventService::canCreateDsgElection($event, $admin), 403, 'Cannot create election');

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

    public function store(Request $request, Event $event)
    {
        /** @var Admin $admin */
        $admin = auth('admin')->user();

        abort_unless(EventService::canCreateDsgElection($event, $admin), 403, 'Cannot create election');

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
            'department_id' => 'required|integer',
            'candidates.*.user_id' => 'integer',
            'candidates.*.position_id' => 'integer',
        ]);

        $validated = $validator->validated();

        $election = Election::make($validated);
        $election->election_type_id = ElectionType::TYPE_DSG;
        $election->event_id = $event->id;
        $election->save();

        if (array_key_exists('candidates', $validated)) {
            $election->candidates()->createMany($validated['candidates']);
        }

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'DSG election successfully created!');
    }
}
