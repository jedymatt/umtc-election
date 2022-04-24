<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

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
            ->orderBy('name')->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->pluck('name', 'id');

        return view('admin.admins.create', compact('departments'));
    }

    public function store(StoreAdminRequest $request)
    {
        $hashedPassword = Hash::make($request->validated('password'));
        $validated = array_merge($request->validated(), ['password' => $hashedPassword]);

        Admin::create($validated);

        return redirect()->route('admin.admins.index');
    }
}
