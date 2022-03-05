<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Position;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElectionCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Election $election
     * @return Application|Factory|View
     */
    public function index(Election $election)
    {
        $positions = $election->electionType->positions;

        return view('admin.elections.candidates.index', compact([
            'election', 'positions',
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Election $election
     * @return Response
     */
    public function create(Election $election)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Election $election
     * @return Response
     */
    public function store(Request $request, Election $election)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Election $election
     * @param Candidate $candidate
     * @return Response
     */
    public function show(Election $election, Candidate $candidate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Election $election
     * @param Candidate $candidate
     * @return Response
     */
    public function edit(Election $election, Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Election $election
     * @param Candidate $candidate
     * @return Response
     */
    public function update(Request $request, Election $election, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Election $election
     * @param Candidate $candidate
     * @return Response
     */
    public function destroy(Election $election, Candidate $candidate)
    {
        //
    }
}
