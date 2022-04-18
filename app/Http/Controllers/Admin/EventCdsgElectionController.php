<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Event;
use App\Services\ElectionService;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventCdsgElectionController extends Controller
{
    public function create(Event $event)
    {
        /** @var Admin $user */
        $user = auth('admin')->user();

        abort_unless((new EventService($event))->canCreateCdsgElection($user), 403, 'Cannot create election');

        $dsgElections = $event->dsgElections;

        foreach ($dsgElections as $election) {
            abort_if((new ElectionService($election))->hasWinnersConflict(), 403, 'Detected Election Winners Conflict');
        }

        return view('admin.events.cdsg-elections.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        /** @var Admin $user */
        $user = auth('admin')->user();

        abort_unless((new EventService($event))->canCreateCdsgElection($user), 403, 'Cannot create election');

        $dsgElections = $event->dsgElections;

        foreach ($dsgElections as $election) {
            abort_if((new ElectionService($election))->hasWinnersConflict(), 403, 'Detected Election Winners Conflict');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before:end_at',
            'end_at' => 'required|date|after:start_at',
            'candidates.*.user_id' => 'integer',
            'candidates.*.position_id' => 'integer',
        ]);

        $validated = $validator->validate();

        $election = Election::make($validated);
        $election->election_type_id = ElectionType::TYPE_CDSG;
        $election->event_id = $event->id;
        $election->save();

        if (array_key_exists('candidates', $validated)) {
            $election->candidates()->createMany($validated['candidates']);
        }

        return redirect()->route('admin.events.show', $event);
    }
}
