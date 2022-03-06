<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use App\Models\User;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $departments = Department::orderBy('name')->get();
        $programs = Program::orderBy('name')->get();
        $yearLevels = YearLevel::orderBy('name')->get();
        return view('profile.show', compact(
            'user', 'departments', 'programs', 'yearLevels'
        ));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'department_id' => 'required|integer',
            'program_id' => 'required|integer',
            'year_level_id' => 'required|integer',
        ]);

        $request->user()->update($validator->validated());

        return redirect()->route('user-profile.show');
    }
}
