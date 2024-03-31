<?php

namespace App\Services;

use App\Enums\ElectionType;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ElectionService
{
    public static function canVote(Election $election, User $user): bool
    {
        $election->loadMissing(['votes', 'candidates']);

        if ($election->end_at->isPast()) {
            return false;
        }

        if ($election->votes->contains('user_id', $user->id)) {
            return false;
        }

        if ($election->type === ElectionType::Dsg && $election->department_id !== $user->department_id) {
            return false;
        }

        if ($election->type === ElectionType::Cdsg && $election->candidates->doesntContain('user_id', $user->id)) {
            return false;
        }

        return true;
    }


    private static function constraintsQuery(User $user): Builder
    {
        return Election::query()
            ->with(['department'])
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
            ->active();
    }

    /**
     * @return EloquentCollection<Election>
     */
    public static function getVotableElectionsFromUser(User $user): EloquentCollection
    {
        return is_null($user->department_id)
            ? $user->newCollection()
            : self::constraintsQuery($user)
            ->whereDoesntHave('votes', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
    }

    /**
     * @return EloquentCollection<Election>
     */
    public static function getVotedElectionsFromUser(User $user): EloquentCollection
    {
        return is_null($user->department_id)
            ? $user->newCollection()
            : self::constraintsQuery($user)
            ->whereRelation('votes', 'user_id', '=', $user->id)
            ->get();
    }

    /**
     * @return EloquentCollection<Election>
     */
    public static function pastElectionsByUser(User $user): EloquentCollection
    {
        return is_null($user->department_id)
            ? $user->newCollection()
            : Election::query()
            ->with(['department'])
            ->orWhere(function (Builder $query) use ($user) {
                $query->where('department_id', '=', $user->department_id);
            })->orWhere(function (Builder $query) {
                $query->where('type', '=', ElectionType::Cdsg);
            })->ended()->get();
    }

    public static function createDsgElection(array $data): Election
    {
        return Election::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => ElectionType::Dsg,
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
            'type' => ElectionType::Cdsg,
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
        ]);
    }
}
