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
            ->with('department')
            ->orderByDesc('is_super_admin')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.admin-management.index')
            ->with('admins', $admins);
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.admin-management.create')
            ->with('departments', $departments);
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
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'department_id' => $request->get('department_id'),
        ]);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin account successfully created!');
    }
}
