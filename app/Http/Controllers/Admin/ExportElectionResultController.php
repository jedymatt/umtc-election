<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;

class ExportElectionResultController extends Controller
{
    public function store(Request $request, Election $election)
    {
        // TODO: Export Excel
    }
}
