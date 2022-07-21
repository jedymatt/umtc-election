<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Department;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use function redirect;
use function view;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $departments = Department::orderBy('name')->get();
        $yearLevels = YearLevel::orderBy('name')->get();

        return view('profile.show', compact(
            'user',
            'departments',
            'yearLevels'
        ));
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $request->user()->update($request->validated());

        return redirect()->route('user-profile')
            ->with('success', 'Profile updated successfully!');
    }
}
