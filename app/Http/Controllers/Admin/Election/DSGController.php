<?php

namespace App\Http\Controllers\Admin\Election;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreElectionRequest;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use Illuminate\Http\Request;

class DSGController extends Controller
{
    protected $electionType;

    protected $departments;

    /**
     * @param $electionType
     * @param $departments
     */
    public function __construct()
    {
        $this->electionType = ElectionType::whereName('DSG')->firstOrFail();
        $this->departments = Department::orderBy('name')->get();
    }


    public function create()
    {
        $electionType = $this->electionType;
        $departments = $this->departments;
        return view('admin.elections.create-dsg', compact('electionType', 'departments'));
    }

    public function store(StoreElectionRequest $request)
    {
        $election = Election::create($request->validated());

        return redirect()->route('admin.elections.show', compact('election'));
    }
}
