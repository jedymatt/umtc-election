<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        'year_level_id',
        'program_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function availableElections()
    {
        return Election::with(['electionType', 'department'])
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->where('department_id', '=', $this->department_id)
            ->whereDoesntHave('votes.user', function (Builder $query) {
                $query->where('id', $this->id);
            });
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function hasVotedElection(Election $election)
    {
        $voteCount = $this->votes()->where('votes.election_id', $election->id)->count();

        return $voteCount >= 1;
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function winner(): HasOneThrough
    {
        return $this->hasOneThrough(Winner::class, Candidate::class);
    }
}
