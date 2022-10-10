<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admin::class, 'admin');
    }

    public function index()
    {
        $admins = Admin::query()
            ->orderByDesc('is_super_admin')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.admin-management.index', compact('admins'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->pluck('name', 'id');

        return view('admin.admin-management.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin account successfully created!');
    }
}
