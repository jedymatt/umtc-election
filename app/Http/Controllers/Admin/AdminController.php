<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Department;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Admin::class, 'admin');
    }

    public function index()
    {
        $admins = Admin::orderBy('name')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->pluck('name', 'id');
        return view('admin.admins.create', compact('departments'));
    }

    public function store(StoreAdminRequest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->department()->associate($request->input('department'));
        $admin->save();
        return redirect()->route('admin.admins.index');
    }

    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }
}
