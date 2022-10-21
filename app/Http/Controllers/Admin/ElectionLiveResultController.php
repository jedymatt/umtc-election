<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;

class ElectionLiveResultController extends Controller
{
    public function __invoke(Election $election)
    {
        return view('admin.elections.live-result', compact('election'));
    }
}
