<?php

namespace App\Http\Controllers\Admin\Election;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreElectionRequest;
use App\Http\Requests\Admin\UpdateElectionRequest;
use App\Models\Election;
use App\Models\ElectionType;

class CDSGController extends Controller
{
    protected $electionType;

    public function __construct()
    {
        $this->electionType = ElectionType::whereName('CDSG')->firstOrFail();
    }


    public function create()
    {
        $electionType = $this->electionType;

        return view('admin.elections.create-cdsg', compact('electionType'));
    }

    public function store(StoreElectionRequest $request)
    {
        $election = Election::create($request->validated());

        return redirect()->route('admin.elections.show', $election);
    }
}
