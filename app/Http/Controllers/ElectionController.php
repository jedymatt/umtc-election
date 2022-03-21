<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionType;
use Illuminate\Support\Facades\Auth;
use function view;

class ElectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeElections = Election::with(['department', 'electionType'])
            ->active()->ofDepartment($user->department_id)
            ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
            ->get();

        $endedElections = Election::ended()
            ->ofDepartment($user->department_id)
            ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
            ->get();
        return view('elections.index', compact('activeElections', 'endedElections'));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
