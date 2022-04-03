<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventCdsgElectionController extends Controller
{
    public function create(Event $event)
    {
        return view('admin.events.cdsg-elections.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {

        return redirect()->route('admin.events.show', $event);
    }
}
