<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ElectionWinnersExport;
use App\Http\Controllers\Controller;
use App\Models\Election;
use Maatwebsite\Excel\Facades\Excel;

class ElectionWinnerExportExcelController extends Controller
{
    public function __invoke(Election $election)
    {
        $fileName = 'election_'.str($election->title)->slug('_').'_'.now()->timestamp.'.xlsx';

        return Excel::download(new ElectionWinnersExport($election), $fileName);
    }
}
