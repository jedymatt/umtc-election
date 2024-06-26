<?php

namespace App\Exports;

use App\Models\Election;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ElectionWinnersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected Election $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    public function collection(): Collection
    {
        return $this->election->winners;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Position',
            'Votes',
        ];
    }

    public function map($row): array
    {
        return [
            $row->user->name,
            $row->position->name,
            $row->pivot->votes,
        ];
    }
}
