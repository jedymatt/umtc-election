<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Event;
use App\Services\ElectionService;
use App\Services\EventService;
use Illuminate\Database\Eloquent\Builder;
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

        $cdsgElection = $event->cdsgElection()->first();

        $dsgElectionsHasWinnersConflict = [];
        foreach ($dsgElections as $election) {
            if (!$election->isEnded()) {
                $dsgElectionsHasWinnersConflict[$election->id] = false;
                continue;
            }

            $electionService = new ElectionService($election);

            if ($election->winners()->doesntExist()) {
                $electionService->saveWinners();
            }
            $dsgElectionsHasWinnersConflict[$election->id] = $electionService->hasWinnersConflict();
        }

        $cdsgElectionHasWinnersConflict = $cdsgElection != null
            && (new ElectionService($cdsgElection))->hasWinnersConflict();

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
        abort_unless(auth('admin')->user()->is_super_admin, 403);

        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth('admin')->user()->is_super_admin, 403);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:events',
        ]);

        $event = Event::create($validator->validated());

        return redirect()->route('admin.events.show', $event);
    }
}
