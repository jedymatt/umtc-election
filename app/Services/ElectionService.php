<?php

namespace App\Services;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Position;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ElectionService
{
    private Election $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public function canVote(User $user): bool
    {
        if (!$this->election->isActive()) {
            return false;
        }

        if ($this->election->election_type_id == ElectionType::TYPE_DSG
            && $this->election->department_id != $user->department_id) {
            return false;
        }

        if (Vote::where('election_id', '=', $this->election->id)
            ->where('user_id', '=', $user->id)
            ->exists()) {
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


    public function getPreWinners(): Collection
    {
        $candidates = Candidate::ofElection($this->election)->withCount('votes')
            ->orderBy('position_id')
            ->get();

        $positions = Position::ofElectionType($this->election->electionType)->get();

        $winners = collect();

        foreach ($positions as $position) {
            $maxVotesCount = $candidates->where('position_id', $position->id)->max('votes_count');

            $winners[] = $candidates->where('position_id', '=', $position->id)
                ->where('votes_count', '=', $maxVotesCount);

        }

        return $winners->flatten();
    }

    public function hasWinnersConflict(): bool
    {
        $candidates = Candidate::ofElection($this->election)->withCount('votes')
            ->orderBy('position_id')
            ->get();

        $positions = Position::ofElectionType($this->election->electionType)->get();


        foreach ($positions as $position) {
            $maxVotesCount = $candidates->where('position_id', $position->id)->max('votes_count');

            $winners = $candidates->where('position_id', '=', $position->id)
                ->where('votes_count', '=', $maxVotesCount);

            if ($winners->count() > 1 ) {
                return true;
            }

        }

        return false;
    }

    public function getWinnerConflicts(): Collection
    {

        // FIXME: Algorithm mismatch
        $candidateWinners = $this->getPreWinners();

        $conflicts = collect();

        foreach ($candidateWinners as $candidates) {
            if ($candidates->count() > 1) {
                $conflicts[] = $candidates;
            }
        }

        return $conflicts;
    }
}
