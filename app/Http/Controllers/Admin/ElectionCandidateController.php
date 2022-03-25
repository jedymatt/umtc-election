<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use function view;

class ElectionCandidateController extends Controller
{

    public function index(Election $election)
    {
        $positions = $election->electionType->positions;

        return view('admin.elections.candidates.index', compact([
            'election', 'positions',
        ]));
    }
}
