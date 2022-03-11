<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        return view('elections.result.show', $election);
    }
}
