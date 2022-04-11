<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_url',
        'user_id',
        'election_id',
        'position_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(Vote::class);
    }

    public function winner(): HasOne
    {
        return $this->hasOne(Winner::class);
    }


    public function scopeOfElection(Builder $query, Election $election): Builder
    {
        return $query->where('election_id', $election->id);
    }

    public function scopeOfPosition(Builder $query, Position $position): Builder
    {
        return $query->where('position_id', $position->id);
    }
}
