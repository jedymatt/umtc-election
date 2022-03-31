<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function view;

class ElectionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->department_id == null) {
            $activeElections = Election::with(['department', 'electionType'])
                ->active()
                ->where('election_type_id', ElectionType::TYPE_CDSG)
                ->get();

            $endedElections = Election::ended()
                ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
                ->get();
        } else {
            $department = $user->department;

            $activeElections = Election::with(['department', 'electionType'])
                ->active()
                ->ofDepartment($department)
                ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
                ->get();

            $endedElections = Election::ended()
                ->ofDepartment($department)
                ->orWhere('election_type_id', ElectionType::TYPE_CDSG)
                ->get();
        }


        return view('elections.index', compact('activeElections', 'endedElections'));
    }

    public function show(Election $election)
    {
        return view('elections.show', compact('election'));
    }
}
