<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function electionType(): BelongsToMany
    {
        return $this->belongsToMany(ElectionType::class);
    }

    public function scopeCdsgElection(Builder $query)
    {
        $query->whereRelation('electionType', 'id', ElectionType::TYPE_CDSG)
            ->orderBy('id');
    }

    public function scopeDsgElection(Builder $query)
    {
        $query->whereRelation('electionType', 'id', ElectionType::TYPE_DSG)
            ->orderBy('id');
    }

    public function scopeOfElectionType(Builder $query, ElectionType $electionType)
    {
        $query->whereRelation('electionType', 'id', $electionType->id)
            ->orderBy('id');
    }
}
