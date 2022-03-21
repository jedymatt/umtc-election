<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Election;
use function view;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        return view('elections.result.show', $election);
    }
}
