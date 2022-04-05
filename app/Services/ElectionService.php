<?php

namespace App\Services;

use App\Models\Election;
use App\Models\ElectionType;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ElectionService
{
    private Election $election;

    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public function canVote(User $user): bool
    {
        if (! $this->election->isActive()) {
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

        return $title.' '.$dateString.$extension;
    }
}
