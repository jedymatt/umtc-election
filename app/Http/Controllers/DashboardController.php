<?php

namespace App\Http\Controllers;

use App\Services\ElectionService;

// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {
        $elections = ElectionService::getVotableElectionsFromUser(auth()->user());

        return view('dashboard', compact('elections'));
    }
}
