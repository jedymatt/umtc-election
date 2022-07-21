<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Department;
use App\Models\Event;

class EventService
{
    public static function createDsgElectionFailureMessage(Event $event, Admin $admin): string
    {
        $dsgElectionKeys = $event->dsgElections()->pluck('id');

        if ($dsgElectionKeys->count() == Department::count()) {
            return 'Reached max number of DSG Elections';
        }

        if (! $admin->is_super_admin && $dsgElectionKeys->contains($admin->department_id)) {
            return 'Election with '.$admin->department->name.' already exists';
        }

        return '';
    }

    public static function createCdsgElectionFailureMessage(Event $event, Admin $admin): string
    {
        if (! $admin->is_super_admin) {
            return 'Unauthorized';
        }

        if ($event->cdsgElection()->exists()) {
            return 'CDSG election already exists';
        }

        $dsgElections = $event->dsgElections();

        if ($dsgElections->count() < Department::count()) {
            return 'Incomplete number of DSG elections';
        }

        $activeDsgElections = $dsgElections->active();

        $activeDsgElectionsCount = $activeDsgElections->count();
        if ($activeDsgElectionsCount > 0) {
            return 'Found '.$activeDsgElectionsCount.' active DSG elections';
        }

        if ($event->hasConflictedElections()) {
            return 'Found unresolved DSG winners';
        }

        return '';
    }

    public function createEvent(array $data): Event
    {
        return Event::create([
            'name' => $data['name'],
        ]);
    }
}
