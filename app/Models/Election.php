<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Election extends Model
{
    use HasFactory;

    public const STATUS_NOT_STARTED = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_ENDED = 3;


    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'election_type_id',
        'department_id',
        'cdsg_id',
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

    public function status(): int
    {
        $now = Carbon::now();

        if ($now > $this->end_at) {
            return static::STATUS_ENDED;
        }

        if ($now >= $this->start_at) {
            return static::STATUS_ACTIVE;
        }

        return static::STATUS_NOT_STARTED;
    }

    public function statusMessage(): string
    {
        $status = $this->status();

        return match ($status) {
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_ENDED => 'Ended',
            default => 'Not Yet Started',
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

    public function latestActive(): Election
    {
        return $this->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->latest();
    }


    public function hasVotedByUser(User $user)
    {
        $voteCount = $this->votes()->where('votes.user_id', $user->id)->count();

        return $voteCount >= 1;
    }

    public function scopeNoCdsg(Builder $query)
    {
        return $query->where('cdsg_id', null);
    }


    public function winners()
    {
        $positions = $this->electionType->positions;

        $candidates = $this->candidates;

        $winners = [];

        foreach ($positions as $position) {
            $winners[] = $candidates->where('position_id', '=', $position->id)
                ->max('votes_count')
                ->get();

        }

        dd($winners);
    }
}
