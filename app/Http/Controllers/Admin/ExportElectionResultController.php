<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelElectionResultExport;
use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportElectionResultController extends Controller
{
    public function store(Election $election)
    {
        return (new ExcelElectionResultExport($election))->download(str($election->title.'_'.now()->toDateString().'.xlsx')->snake());
    }
}
