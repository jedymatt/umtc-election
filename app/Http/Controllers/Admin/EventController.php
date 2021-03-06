<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Election;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $dsgElections = $event->dsgElections()
            ->orderBy(Department::select('name')
                ->whereColumn('department_id', '=', 'id'))
            ->get();

        /** @var Election $cdsgElection */
        $cdsgElection = $event->cdsgElection()->first();

        $dsgElectionsHasWinnersConflict = [];
        foreach ($dsgElections as $election) {
            if (! $election->isEnded()) {
                $dsgElectionsHasWinnersConflict[$election->id] = false;
                continue;
            }

            $dsgElectionsHasWinnersConflict[$election->id] = $election->hasConflictedWinners();
        }

        $cdsgElectionHasWinnersConflict = $cdsgElection != null
            && $cdsgElection->hasConflictedWinners();

        return view('admin.events.show', compact(
            'event',
            'dsgElections',
            'cdsgElection',
            'dsgElectionsHasWinnersConflict',
            'cdsgElectionHasWinnersConflict',
        ));
    }

    public function create()
    {
        abort_if(! auth('admin')->user()->is_super_admin, 403);

        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        abort_if(! auth('admin')->user()->is_super_admin, 403);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:events',
        ]);

        $event = Event::create($validator->validated());

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event successfully created!');
    }
}
