<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Candidate
 *
 * @property int $id
 * @property int $user_id
 * @property int $position_id
 * @property int $election_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Election $election
 * @property-read \App\Models\Position $position
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vote[] $votes
 * @property-read int|null $votes_count
 * @property-read \App\Models\Winner|null $winner
 *
 * @method static \Database\Factories\CandidateFactory factory(...$parameters)
 * @method static Builder|Candidate newModelQuery()
 * @method static Builder|Candidate newQuery()
 * @method static Builder|Candidate ofElection(\App\Models\Election $election)
 * @method static Builder|Candidate ofPosition(\App\Models\Position $position)
 * @method static Builder|Candidate query()
 * @method static Builder|Candidate whereCreatedAt($value)
 * @method static Builder|Candidate whereElectionId($value)
 * @method static Builder|Candidate whereId($value)
 * @method static Builder|Candidate wherePositionId($value)
 * @method static Builder|Candidate whereUpdatedAt($value)
 * @method static Builder|Candidate whereUserId($value)
 * @mixin \Eloquent
 */
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
