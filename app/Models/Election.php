<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Election
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int $election_type_id
 * @property int|null $department_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidate[] $candidates
 * @property-read int|null $candidates_count
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\ElectionType $electionType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vote[] $votes
 * @property-read int|null $votes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Winner[] $winners
 * @property-read int|null $winners_count
 * @method static Builder|Election active()
 * @method static Builder|Election doesntHaveVotesFromUser(\App\Models\User $user)
 * @method static Builder|Election electionTypeCdsg()
 * @method static Builder|Election electionTypeDsg()
 * @method static Builder|Election ended()
 * @method static \Database\Factories\ElectionFactory factory(...$parameters)
 * @method static Builder|Election newModelQuery()
 * @method static Builder|Election newQuery()
 * @method static Builder|Election noCdsg()
 * @method static Builder|Election ofDepartment(\App\Models\Department $department)
 * @method static Builder|Election ofDepartmentId(int $departmentId)
 * @method static Builder|Election ofElectionTypeId(int $electionTypeId)
 * @method static Builder|Election query()
 * @method static Builder|Election whereCreatedAt($value)
 * @method static Builder|Election whereDepartmentId($value)
 * @method static Builder|Election whereDescription($value)
 * @method static Builder|Election whereElectionTypeId($value)
 * @method static Builder|Election whereEndAt($value)
 * @method static Builder|Election whereId($value)
 * @method static Builder|Election whereStartAt($value)
 * @method static Builder|Election whereTitle($value)
 * @method static Builder|Election whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Election extends Model
{
    use HasFactory;

    // TODO: Improve naming statuses
    // And decide if having winners and not having winners is a status

    public const STATUS_PENDING = 1; // Election has not started yet

    public const STATUS_ACTIVE = 2;

    public const STATUS_ONGOING = 2;

    public const STATUS_ENDED = 3;

    public const STATUS_FINISHED = 3; // voting done, winners declared

    public const STATUS_EXPIRED = 3;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'election_type_id',
        'department_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function electionType(): BelongsTo
    {
        return $this->belongsTo(ElectionType::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('start_at', '<=', now())
            ->where('end_at', '>=', now());
    }

    public function scopeEnded(Builder $query): Builder
    {
        return $query->where('end_at', '<', now());
    }

    public function scopeOfDepartment(Builder $query, Department $department): Builder
    {
        return $query->where('department_id', $department->id)
            ->where('election_type_id', ElectionType::TYPE_DSG);
    }

    public function scopeOfDepartmentId(Builder $query, int $departmentId): Builder
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeOfElectionTypeId(Builder $query, int $electionTypeId): Builder
    {
        return $query->where('election_type_id', $electionTypeId);
    }

    public function scopeElectionTypeDsg(Builder $query): Builder
    {
        return $query->where('election_type_id', ElectionType::TYPE_DSG);
    }

    public function scopeElectionTypeCdsg(Builder $query): Builder
    {
        return $query->where('election_type_id', ElectionType::TYPE_CDSG);
    }

    public function status(): int
    {
        $now = Carbon::now();

        if ($now > $this->end_at) {
            return static::STATUS_ENDED;
        }

        if ($now >= $this->start_at) {
            return static::STATUS_ONGOING;
        }

        return static::STATUS_PENDING;
    }

    public function statusMessage(): string
    {
        $status = $this->status();

        return match ($status) {
            static::STATUS_ONGOING => 'Ongoing',
            static::STATUS_EXPIRED => 'Expired',
            default => 'Pending',
        };
    }

    public function isActive(): bool
    {
        return $this->status() === static::STATUS_ACTIVE;
    }

    public function isEnded(): bool
    {
        return $this->status() === static::STATUS_ENDED;
    }

    public function isOngoing(): bool
    {
        return $this->status() === static::STATUS_ONGOING;
    }

    public function isPending(): bool
    {
        return $this->status() === static::STATUS_PENDING;
    }

    public function isExpired(): bool
    {
        return $this->status() === static::STATUS_EXPIRED;
    }

    public function latestActive(): self
    {
        return $this->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->latest();
    }

    public function hasVotedByUser(User $user)
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }

    public function scopeNoCdsg(Builder $query)
    {
        return $query->where('cdsg_id', null);
    }

    public function isTypeCdsg(): bool
    {
        return $this->election_type_id === ElectionType::TYPE_CDSG;
    }

    public function isTypeDsg(): bool
    {
        return $this->election_type_id === ElectionType::TYPE_DSG;
    }

    public function hasConflictedWinners(): bool
    {
        return $this->active() && DB::table('winners')
            ->select('candidates.position_id')
            ->join('candidates', 'candidates.id', '=', 'winners.candidate_id')
            ->where('winners.election_id', $this->id)
            ->havingRaw('COUNT(candidates.position_id) > ?', [1])
            ->groupBy('candidates.position_id')
            ->exists();
    }

    public function scopeDoesntHaveVotesFromUser(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave('votes', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function hasNoWinners(): bool
    {
        return $this->winners()->doesntExist();
    }
}
