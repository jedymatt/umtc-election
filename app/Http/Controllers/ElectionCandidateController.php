<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Position;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
