<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $departments = Department::orderBy('name')->get();

        return view('profile.show', compact(
            'user',
            'departments',
        ));
    }
}
