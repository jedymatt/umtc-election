<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Department;
use App\Http\Requests\Admin\StoreAdminRequest;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
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

    public function store(StoreAdminRequest $request)
    {
        $hashedPassword = Hash::make($request->validated('password'));
        $validated = array_merge($request->validated(), ['password' => $hashedPassword]);

        Admin::create($validated);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin account successfully created!');
    }
}
