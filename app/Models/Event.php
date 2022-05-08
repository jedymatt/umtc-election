<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

    public function dsgElections(): HasMany
    {
        return $this->hasMany(Election::class)
            ->where('election_type_id', '=', ElectionType::TYPE_DSG);
    }

    public function cdsgElection(): HasOne
    {
        return $this->hasOne(Election::class)
            ->where('election_type_id', '=', ElectionType::TYPE_CDSG);
    }

    public function hasConflictedElections(): bool
    {
        foreach ($this->elections as $election) {
            if ($election->hasConflictedWinners()) {
                return true;
            }
        }

        return false;
    }
}
