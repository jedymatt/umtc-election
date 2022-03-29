<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreElectionRequest;
use App\Http\Requests\Admin\UpdateElectionRequest;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use function view;

class ElectionController extends Controller
{

    public function index()
    {
        $elections = Election::with(['electionType', 'department'])->latest()->paginate(10);
        return view('admin.elections.index', compact('elections'));
    }

    public function store(StoreElectionRequest $request)
    {
        $election = Election::create($request->validated());

        return redirect()->route('admin.elections.show', compact('election'));
    }

    public function show(Election $election)
    {
        $positions = $election->loadMissing('electionType')->electionType->positions;
        return view('admin.elections.show', compact('election', 'positions'));
    }
}
