<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ElectionWinnersExport;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ElectionWinnerExportExcelController extends Controller
{
    public function store(Election $election)
    {
        $fileName = (new ElectionService($election))->generateFileName();

        return Excel::download(new ElectionWinnersExport($election), $fileName);
    }
}
