<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDSGElectionRequest;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
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
        return view('admin.cdsg-elections.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at' => 'required|date|after:start_at',
        ]);

        $election = Election::make($validator->validated());
        $election->electionType()->associate($this->electionType);
        $election->save();

        return redirect()->route('admin.elections.index');
    }
}
