<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CdsgElectionController extends Controller
{
    protected $electionType;

    public function __construct()
    {
        $this->electionType = ElectionType::whereName('CDSG')->firstOrFail();
    }

    public function create()
    {
        $departments = Department::with('availableDsgElections')->get();
        return view('admin.cdsg-elections.create', compact('departments'));
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
        ]);

        $election = Election::make($validator->validated());
        $election->electionType()->associate($this->electionType);
        $election->save();
        // TODO: Remove Tag implementation
        $tag = Tag::create();
        $election->tag()->associate($tag);
        Election::whereIn('id', $request->input('elections'))
            ->update(['tag_id' => $tag->id]);
        return redirect()->route('admin.elections.index');
    }
}
