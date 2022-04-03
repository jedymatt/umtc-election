<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Department;
use App\Models\ElectionType;
use App\Models\Event;

class EventService
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;

        $event->loadMissing('elections');
    }

    public function canCreateDsgElection(Admin $user): bool
    {
        $occupiedDepartments = $this->event->elections->map(function ($election) {
            return $election->department_id;
        })->toArray();

        $hasAvailableDepartments = Department::orderBy('name')
            ->whereNotIn('id', $occupiedDepartments)
            ->exists();

        if ($user->is_super_admin && !$hasAvailableDepartments) {
            return false;

        }

        if (!$user->is_super_admin && in_array($user->department_id, $occupiedDepartments)) {
            return false;
        }

        return true;
    }

    public function canCreateCdsgElection(Admin $user): bool
    {
        if (!$user->is_super_admin) {
            return false;
        }

        $hasCdsgElection = $this->event->elections()
            ->where('election_type_id', '=', ElectionType::TYPE_DSG)
            ->exists();

        if ($hasCdsgElection) {
            return false;
        }

        $dsgElectionsCount = $this->event->elections
            ->where('election_type_id', '=', ElectionType::TYPE_DSG)
            ->count();

        if ($dsgElectionsCount != 7) {
            return false;
        }

        return true;
    }

}
