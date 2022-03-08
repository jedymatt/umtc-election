<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDSGElectionRequest;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionTag;
use App\Models\ElectionType;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CDSGElectionController extends Controller
{
    protected $electionType;

    public function __construct()
    {
        $this->electionType = ElectionType::whereName('CDSG')->firstOrFail();
    }

    public function create()
    {
        $departments = Department::with('availableElections')->get();
        return view('admin.cdsg-elections.create', compact('departments'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
        ]);

        $election = Election::make($validator->validated());
        $election->electionType()->associate($this->electionType);
        $election->save();
        $tag = Tag::create();
        $election->tag()->associate($tag);
        Election::whereIn('id', $request->input('elections'))
            ->update(['tag_id' => $tag->id]);
        return redirect()->route('admin.elections.index');
    }
}
