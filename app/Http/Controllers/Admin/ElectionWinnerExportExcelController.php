<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ElectionWinnersExport;
use App\Http\Controllers\Controller;
use App\Models\Election;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ElectionWinnerExportExcelController extends Controller
{
    public function store(Election $election)
    {
        $fileName = Str::slug($election->title).'_'.now()->timestamp.'.xlsx';

        return Excel::download(new ElectionWinnersExport($election), $fileName);
    }
}
