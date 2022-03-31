<?php

namespace App\Exports;

use App\Models\Election;
use App\Models\Position;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelElectionResultExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private Election $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public function view(): View
    {
        $positions = Position::ofElectionType($this->election->electionType)->get();
        $candidates = $this->election->candidates()->with('user')->withCount('votes')->get();
        return view('exports.excel-election-result', compact('positions', 'candidates'));
    }

}
