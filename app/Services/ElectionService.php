<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Support\Carbon;
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
        if (!$election->isActive()) {
            return false;
        }

        if ($election->isTypeDsg()
            && $election->department_id != $user->department_id) {

            return false;
        }

        if ($election->isTypeDsg()
            && Election::query()
                ->where('election_type_id', ElectionType::TYPE_DSG)
                ->where('event_id', $election->event_id)
                ->whereRelation('event.elections.votes', 'user_id', $user->id)
                ->exists()) {

            return false;
        }

        if ($election->isTypeCdsg()
            && (Election::query()
                    ->where('election_type_id', ElectionType::TYPE_CDSG)
                    ->where('event_id', $election->event_id)
                    ->whereRelation('event.elections.winners.candidate', 'user_id', '=', $user->id)
                    ->doesntExist()
                || Election::query()
                    ->where('election_type_id', ElectionType::TYPE_CDSG)
                    ->where('id', $election->id)
                    ->whereRelation('votes', 'user_id', $user->id)
                    ->exists())) {

            return false;
        }

        return true;
    }

    public function generateFileName(): string
    {
        $title = $this->election->title;
        $extension = '.xlsx';

        $dateString = Carbon::now()->format('M d, Y u');

        return $title . ' ' . $dateString . $extension;
    }

    /**
     * @return Collection<Candidate>
     */
    public function getWinningCandidates(): Collection
    {
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
        $winners = $this->getWinningCandidates()->map(function ($candidate) {
            return Winner::make([
                'candidate_id' => $candidate->id,
                'election_id' => $this->election->id,
                'votes' => $candidate->votes_count,
            ]);
        });
        $this->election->winners()->saveMany($winners);
    }

    public function hasWinnersConflict(): bool
    {
        $positionWinners = $this->election->winners()->with(['candidate'])->get()
            ->groupBy('candidate.position_id');
        foreach ($positionWinners as $winners) {
            if ($winners->count() > 1) {
                return true;
            }
        }

        return false;
    }

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

    public function getWinningCandidatesConflicts(): Collection
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
}
