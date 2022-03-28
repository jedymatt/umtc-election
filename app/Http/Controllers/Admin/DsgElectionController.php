<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDSGElectionRequest;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DsgElectionController extends Controller
{
    protected $departments;

    public function __construct()
    {
        $this->departments = Department::orderBy('name')->get();
    }

    public function create()
    {
        $departments = $this->departments;
        return view('admin.dsg-elections.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
            'department_id' => 'required|integer',
            'candidates.*.user_id' => 'integer',
            'candidates.*.position_id' => 'integer',
        ]);


        $election = Election::make($validator->validated());
        $election->election_type_id = ElectionType::TYPE_DSG;
        $election->save();

        $election->candidates()->createMany($validator->validated()['candidates']);

        return redirect()->route('admin.elections.index');
    }
}
