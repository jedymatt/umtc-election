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

    // TODO: Analyze the code because it is not clear what it does
    public static function isVotable(Election $election, User $user): bool
    {
        return Election::with('event.votes')
            ->active()
            ->whereRelation('event.votes', 'user_id', '=', $user->id)
            ->where('id', $election->id)
            ->doesntExist();
    }

    // TODO: Refactor this method
    public static function canVote(Election $election, User $user): bool
    {
        return self::isVotable($election, $user);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getWinningCandidates()
    {
        // TODO: Refactor this
        $candidates = $this->election->candidates()->withCount('votes')->orderBy('position_id')->get();

        $candidates = $candidates->groupBy('position_id');

        $winningCandidates = collect();

        foreach ($candidates as $positionCandidates) {
            $maxVotesCount = $positionCandidates->max('votes_count');
            $winningCandidates->push(...$positionCandidates->where('votes_count', '=', $maxVotesCount));
        }

        return $winningCandidates;
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

    // TODO: Refactor this method
    public function getWinnersConflicts(): Collection
    {
        $this->election->winners->loadMissing(['candidate', 'candidate.position']);

        $positionWinners = $this->election->winners()->get()->groupBy('candidate.position.name');

        $winnersConflicts = collect();

        foreach ($positionWinners as $positionName => $winners) {
            if ($winners->count() > 1) {
                $winnersConflicts[$positionName] = $winners;
            }
        }

        return $winnersConflicts;
    }

    public function hasWinningCandidatesConflict(): bool
    {
        $candidates = Candidate::ofElection($this->election)
            ->withCount('votes')
            ->orderBy('position_id')
            ->get();

        $candidates = $candidates->groupBy('position_id');

        foreach ($candidates as $positionCandidates) {
            $maxVotesCount = $positionCandidates->max('votes_count');

            $winners = $positionCandidates->where('votes_count', '=', $maxVotesCount);

            if ($winners->count() > 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return EloquentCollection<Candidate>
     */
    public function getWinningCandidatesConflicts()
    {
        $candidates = Candidate::ofElection($this->election)
            ->with('position')
            ->withCount('votes')
            ->orderBy('position_id')
            ->get();

        $candidates = $candidates->groupBy('position.name');

        $winnersConflicts = collect();

        foreach ($candidates as $positionName => $positionCandidates) {
            $maxVotesCount = $positionCandidates->max('votes_count');

            $winners = $positionCandidates->where('votes_count', '=', $maxVotesCount);

            if ($winners->count() > 1) {
                $winnersConflicts[$positionName] = $winners;
            }
        }

        return $winnersConflicts;
    }

    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function activeElectionsByUser(User $user)
    {
        return Election::with(['department', 'electionType'])
            ->orWhere(function (Builder $query) use ($user) {
                $query->where('election_type_id', ElectionType::TYPE_DSG)
                    ->where('department_id', $user->department_id);
            })
            ->orWhere(function (Builder $query) use ($user) {
                $query->where('election_type_id', ElectionType::TYPE_CDSG)
                    ->whereRelation('event.elections.winners.candidate', 'user_id', '=', $user->id);
            })
            ->active()
            ->get();
    }

    // TODO: refactor this method specially the parameters
    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function getVotableElectionsFromUser(User $user)
    {
        if ($user->department_id === null) {
            return EloquentCollection::empty();
        }

        return Election::with('department', 'electionType')
            ->orWhere(function (Builder $query) use ($user) {
                $query->electionTypeDsg()
                    ->ofDepartmentId($user->department_id);
            })
            ->orWhere(function (Builder $query) use ($user) {
                $query->electionTypeCdsg()
                    ->whereHas('event.elections.winners.candidate', function (Builder $query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            })
            ->active()
            ->doesntHaveEventVotesFromUser($user)
            ->get();
    }

    // TODO: refactor this method specially the parameters
    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function getVotedElectionsFromUser(User $user)
    {
        return Election::with('department', 'electionType')
            ->orWhere(function (Builder $query) use ($user) {
                $query->electionTypeDsg()
                    ->ofDepartmentId($user->department_id);
            })
            ->orWhere(function (Builder $query) use ($user) {
                $query->electionTypeCdsg()
                    ->whereHas('event.elections.winners.candidate', function (Builder $query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            })
            ->active()
            ->hasEventVotesFromUser($user)
            ->get();
    }

    /**
     * @param  User  $user
     * @return EloquentCollection<Election>
     */
    public static function pastElectionsByUser(User $user)
    {
        return Election::with('department', 'electionType')
            ->orWhere(function (Builder $query) use ($user) {
                $query->where('department_id', '=', $user->department_id);
            })
            ->orWhere(function (Builder $query) {
                $query->where('election_type_id', ElectionType::TYPE_CDSG);
            })
            ->ended()
            ->get();
    }

    public static function createDsgElection(array $data): Election
    {
        return  Election::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'election_type_id' => ElectionType::TYPE_DSG,
            'department_id' => $data['department_id'],
            'event_id' => $data['event_id'],
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
            'event_id' => $data['event_id'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }
}
