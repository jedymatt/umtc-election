<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreElectionRequest;
use App\Http\Requests\Admin\UpdateElectionRequest;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
         $candidates = Candidate::ofElection($election)
             ->with(['user', 'user.department', 'position'])
             ->orderBy('position_id')
             ->orderBy(User::select('name')
                 ->whereColumn('candidates.user_id', 'users.id'))
             ->get();

        return view('admin.elections.show', compact('election', 'candidates'));
    }
}
