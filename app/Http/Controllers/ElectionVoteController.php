<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElectionVoteController extends Controller
{
    public function create(Election $election)
    {
        $positions = $election->electionType->positions;
        return view('elections.vote', compact('election', 'positions'));
    }

    public function store(Request $request, Election $election)
    {
        dd('submitted');
//        $validator = Validator::make($request->all(), [
//            ''
//        ]);
    }
}
