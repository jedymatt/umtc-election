<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Department;
use App\Models\ElectionType;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;

class EventService
{
    public static function canCreateDsgElection(Event $event, Admin $admin): bool
    {
        $dsgElectionKeys = $event->dsgElections()->pluck('id');

        if ($dsgElectionKeys->count() == Department::count()) {
            return false;
        }

        if (!$admin->is_super_admin && $dsgElectionKeys->contains($admin->department_id)) {
            return false;
        }

        return true;
    }

    public static function canCreateCdsgElection(Event $event, Admin $admin): bool
    {
        if (!$admin->is_super_admin) {
            return false;
        }

        if ($event->cdsgElection()->exists()) {
            return false;
        }

        $event->loadCount(['dsgElections' => function (Builder $query) {
            $query->ended();
        }]);

        if ($event->dsg_elections_count != Department::count()) {
            return false;
        }

        return true;
    }
}
