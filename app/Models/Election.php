<?php

namespace App\Models;

use App\Enums\ElectionType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Election extends Model
{
    use HasFactory;

    // TODO: Improve naming statuses
    // And decide if having winners and not having winners is a status

    public const STATUS_UPCOMING = 1; // Election has not started yet

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
        'type',
        'department_id',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'type' => ElectionType::class,
    ];

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

    public function winners(): BelongsToMany
    {
        return $this->belongsToMany(Candidate::class, 'winners')->withPivot('votes')->withTimestamps();
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
            ->where('type', ElectionType::Dsg);
    }

    public function scopeOfDepartmentId(Builder $query, int $departmentId): Builder
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeOfElectionTypeId(Builder $query, int $electionTypeId): Builder
    {
        return $query->where('type', $electionTypeId);
    }

    public function scopeElectionTypeDsg(Builder $query): Builder
    {
        return $query->where('type', ElectionType::Dsg);
    }

    public function scopeElectionTypeCdsg(Builder $query): Builder
    {
        return $query->where('type', ElectionType::Cdsg);
    }

    public function status(): int
    {
        $now = Carbon::now();

        if ($this->end_at->isPast()) {
            return static::STATUS_ENDED;
        }

        if ($this->start_at->lessThanOrEqualTo($now)) {
            return static::STATUS_ONGOING;
        }

        return static::STATUS_UPCOMING;
    }

    public function statusMessage(): string
    {
        $status = $this->status();

        return match ($status) {
            static::STATUS_ONGOING => 'Ongoing',
            static::STATUS_EXPIRED => 'Expired',
            static::STATUS_UPCOMING => 'Upcoming',
            default => 'Unknown'
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

    /** @deprecated use isUpcoming() */
    public function isPending(): bool
    {
        return $this->status() === static::STATUS_UPCOMING;
    }

    public function isUpcoming(): bool
    {
        return $this->status() === static::STATUS_UPCOMING;
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
        return $this->type === ElectionType::Cdsg;
    }

    public function isTypeDsg(): bool
    {
        return $this->type === ElectionType::Dsg;
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
