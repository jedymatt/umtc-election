<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Election extends Model
{
    use HasFactory;

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

    public function status(): Attribute
    {
        return Attribute::get(function () {
            $now = now();

            if ($now > $this->end_at) {
                return 'Ended';
            }

            if ($now >= $this->start_at) {
                return 'Active';
            }

            return 'Not yet started';
        });
    }

    public function isActive()
    {
        return $this->start_at <= now() && $this->end_at >= now();
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


    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
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

    public function scopeOfDepartment(Builder $query, int $departmentId): Builder
    {
        return $query->where('department_id', $departmentId)
            ->where('election_type_id', ElectionType::TYPE_DSG);
    }
}
