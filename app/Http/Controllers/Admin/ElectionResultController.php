<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\User;
use Illuminate\Http\Request;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        $positions = $election->electionType->positions;
        $candidates = $election->candidates()
            ->with(['position', 'user'])
            ->withCount('votes')
            ->orderBy(User::select('name')
                ->whereColumn('candidates.user_id', 'users.id'))
            ->get();

        return view('admin.elections.result.show', compact(
            'election', 'positions', 'candidates'
        ));
    }
}
