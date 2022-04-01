<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelElectionResultExport;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class ExportElectionResultController extends Controller
{
    public function store(Election $election)
    {
        abort_unless($election->hasEnded(), 403);

        $fileName = (new ElectionService($election))->generateFileName();
        return (new ExcelElectionResultExport($election))
            ->download($fileName);
    }
}
