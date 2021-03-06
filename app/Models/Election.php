<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Election extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 1;

    public const STATUS_ACTIVE = 2;

    public const STATUS_ONGOING = 2;

    public const STATUS_ENDED = 3;

    public const STATUS_EXPIRED = 3;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'election_type_id',
        'department_id',
        'event_id',
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

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
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
        $positionIdWinners = $this->winners()->with(['candidate'])->get()
            ->groupBy('candidate.position_id');
        foreach ($positionIdWinners as $positionId => $winners) {
            if ($winners->count() > 1) {
                return true;
            }
        }

        return false;
    }

    public function scopeDoesntHaveVotesFromUser(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave('votes', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function scopeDoesntHaveEventVotesFromUser(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave('event.votes', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    public function scopeHasEventVotesFromUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('event.votes', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }
}
