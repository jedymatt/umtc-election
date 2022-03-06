<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ActiveElectionController extends Controller
{
    public function index()
    {
        $now = now();
        $activeElections = Election::where('start_at', '<=', $now)
            ->where('end_at', '<=', $now )
            ->latest()->get();
        return response()->json($activeElections);
    }
}
