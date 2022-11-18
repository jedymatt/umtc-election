<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Winner
 *
 * @property int $id
 * @property int $election_id
 * @property int $candidate_id
 * @property int $votes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Candidate $candidate
 * @property-read \App\Models\Election $election
 *
 * @method static \Database\Factories\WinnerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Winner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Winner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Winner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Winner whereCandidateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Winner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Winner whereElectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Winner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Winner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Winner whereVotes($value)
 * @mixin \Eloquent
 */
class Winner extends Model
{
    use HasFactory;

    public $fillable = [
        'election_id',
        'candidate_id',
        'votes',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}
