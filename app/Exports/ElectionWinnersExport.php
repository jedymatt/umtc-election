<?php

namespace App\Exports;

use App\Models\Election;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ElectionWinnersExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    protected Election $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public function collection(): HasMany|Collection
    {
        return $this->election->winners;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Position',
            'Number of Votes',
        ];
    }

    public function map($row): array
    {
        return [
            $row->candidate->user->name,
            $row->candidate->position->name,
            $row->votes,
        ];
    }
}
