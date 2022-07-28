<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use function view;

class ElectionController extends Controller
{
    public function index()
    {
        return view('admin.elections.index');
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

    public function create()
    {
        return view('admin.elections.create');
    }
}
