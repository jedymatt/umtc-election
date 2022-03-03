<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElectionRequest;
use App\Models\Department;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function create(Department $department)
    {
        // TODO: view
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreElectionRequest $request
     * @param \App\Models\Department $department
     * @return \Illuminate\Http\Response
     * @noinspection PhpFullyQualifiedNameUsageInspection
     */
    public function store(StoreElectionRequest $request, Department $department)
    {
        $department->elections()->create($request->validated());

        // TODO: redirect route
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department, Election $election)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department, Election $election)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department, Election $election)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @param  \App\Models\Election  $election
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Election $election)
    {
        //
    }
}
