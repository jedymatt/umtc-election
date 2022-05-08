<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Http\Request;

class ElectionResultController extends Controller
{
    public function show(Election $election)
    {
        abort_unless($election->isEnded(), 403);

        abort_if(($election->winners()->doesntExist()
            || (new ElectionService($election))->hasWinnersConflict()), 403);

        $winners = $election->winners;

        return view('elections.result', compact('winners'));
    }
}
