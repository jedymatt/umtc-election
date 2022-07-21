<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        $winners = $election->winners;

        return view('admin.elections.result', compact('winners'));
    }
}
