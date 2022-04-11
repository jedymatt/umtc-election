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


    public function calculateCandidateWinners(): Collection
    {
        $candidates = Candidate::ofElection($this->election)->withCount('votes')
            ->orderBy('position_id')
            ->orderBy('votes_count', 'desc') // FIXME: Tentative remove since it is of no effect
            ->get();

        $positions = Position::ofElectionType($this->election->electionType)->get();

        $winners = collect();

        foreach ($positions as $position) {
            $maxVotesCount = $candidates->where('position_id', $position->id)->max('votes_count');

            $winners[] = $candidates->where('position_id', '=', $position->id)
                ->where('votes_count', '=', $maxVotesCount);

        }

        return $winners;
    }
}
