<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeElections = Election::with(['department', 'electionType'])
            ->active()->ofDepartment($user->department_id)
            ->orWhere('election_type_id', ElectionType::CDSG)
            ->get();

        $endedElections = Election::ended()
            ->ofDepartment($user->department_id)
            ->orWhere('election_type_id', ElectionType::CDSG)
            ->get();
        return view('elections.index', compact('activeElections', 'endedElections'));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
