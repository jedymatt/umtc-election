<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class ElectionService
{
    private Election $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public static function canVote(Election $election, User $user): bool
    {
        return Election::query()
            ->where('id', $election->id)
            ->whereDoesntHave('votes', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($election->isTypeDsg(), function (Builder $query) use ($user) {
                $query->where('department_id', $user->department_id);
            })
            ->when($election->isTypeCdsg(), function (Builder $query) use ($user) {
                $query->whereRelation('candidates', 'user_id', $user->id);
            })
            ->exists();
    }

    /**
     * @return EloquentCollection<Candidate>
     */
    public function getWinningCandidates()
    {
        return $this->election->candidates()->withCount('votes')->orderBy('position_id')->get()
            ->groupBy('position_id')->flatMap(function (EloquentCollection $candidates) {
                $maxVotesCount = $candidates->max('votes_count');

                return $candidates->filter(
                    function (Candidate $candidate) use ($maxVotesCount) {
                        return $candidate->votes_count === $maxVotesCount;
                    }
                );
            });
    }

    public function saveWinners(): void
    {
        $this->getWinningCandidates()->each(function ($candidate) {
            Winner::create([
                'candidate_id' => $candidate->id,
                'election_id' => $this->election->id,
                'votes' => $candidate->votes_count,
            ]);
        });
    }

    /**
     * @param  EloquentCollection<Winner>  $winners
     * @return Collection
     */
    public static function getWinnersConflicts(EloquentCollection $winners): Collection
    {
        return $winners->groupBy('candidate.position.name')->filter(fn (EloquentCollection $winners) => $winners->count() > 1);
    }

    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function getVotableElectionsFromUser(User $user)
    {
        return is_null($user->department_id)
            ? EloquentCollection::empty()
            : Election::query()
                ->with(['department', 'electionType'])
                ->where(function (Builder $query) use ($user) {
                    $query->where(
                        function (Builder $query) use ($user) {
                            $query->electionTypeDsg()
                                ->ofDepartmentId($user->department_id);
                        }
                    )->orWhere(
                        function (Builder $query) use ($user) {
                            $query->electionTypeCdsg()
                                ->whereHas(
                                    'candidates',
                                    function (Builder $query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    }
                                );
                        }
                    );
                })
                ->whereDoesntHave('votes', function (Builder $query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->active()
                ->get();
    }

    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function getVotedElectionsFromUser(User $user)
    {
        return is_null($user->department_id)
            ? EloquentCollection::empty()
            : Election::query()
                ->with(['department', 'electionType'])
                ->where(function (Builder $query) use ($user) {
                    $query->where(
                        function (Builder $query) use ($user) {
                            $query->electionTypeDsg()
                                ->ofDepartmentId($user->department_id);
                        }
                    )->orWhere(
                        function (Builder $query) use ($user) {
                            $query->electionTypeCdsg()
                                ->whereHas(
                                    'candidates',
                                    function (Builder $query) use ($user) {
                                        $query->where('user_id', $user->id);
                                    }
                                );
                        }
                    );
                })
                ->whereRelation('votes', 'user_id', '=', $user->id)
                ->active()
                ->get();
    }

    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function pastElectionsByUser(User $user)
    {
        return is_null($user->department_id)
            ? EloquentCollection::empty()
            : Election::query()
                ->with(['department', 'electionType'])
                ->orWhere(function (Builder $query) use ($user) {
                    $query->where('department_id', '=', $user->department_id);
                })->orWhere(function (Builder $query) {
                    $query->where('election_type_id', '=', ElectionType::TYPE_CDSG);
                })->ended()->get();
    }

    public static function createDsgElection(array $data): Election
    {
        return Election::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $data['department_id'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }

    public static function createCdsgElection(array $data): Election
    {
        return Election::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'election_type_id' => ElectionType::TYPE_CDSG,
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }
}
