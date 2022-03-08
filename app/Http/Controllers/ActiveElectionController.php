<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ActiveElectionController extends Controller
{
    public function index()
    {
        $now = now();
        $activeElections = Election::where('start_at', '<=', $now)
            ->where('end_at', '>=', $now )
            ->latest()->get();

        return view('active-elections.index',compact('activeElections'));
    }
}
