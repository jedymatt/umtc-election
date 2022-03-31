<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelElectionResultExport;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportElectionResultController extends Controller
{
    public function store(Election $election)
    {
        $fileName = (new ElectionService($election))->generateFileName();
        return (new ExcelElectionResultExport($election))
            ->download($fileName);
    }
}
