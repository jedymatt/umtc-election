<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Http\Request;

class ElectionSavedWinnerController extends Controller
{
    public function store(Request $request, Election $election)
    {
        (new ElectionService($election))->saveWinners();

        return redirect()->route('admin.monitor-election', $election);
    }
}
