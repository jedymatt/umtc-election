<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CdsgElectionController extends Controller
{
    public function create()
    {
        $departments = Department::all();
        $elections = Election::ended()->whereNull('cdsg_id')->get();
        return view('admin.cdsg-elections.create', compact('departments', 'elections'));
    }

    public function store(Request $request)
    {
        abort_if(!$request->user('admin')->isSuperAdmin(), 403);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before:end_at',
            'end_at' => 'required|date|after:start_at',
            'elections.*' => 'required|integer',
            'elections' => 'required|array|size:7',
            'candidates.*.user_id' => 'integer',
            'candidates.*.position_id' => 'integer',
        ]);

        $election = Election::make($validator->validated());
        $election->election_type_id = ElectionType::TYPE_CDSG;
        $election->save();
        Election::whereIn('id', $request->input('elections'))
            ->update(['cdsg_id' => $election->id]);

        $election->candidates()->createMany($validator->validated()['candidates']);
        return redirect()->route('admin.elections.index');
    }
}
