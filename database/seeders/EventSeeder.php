<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Department;
use App\Models\Election;
use App\Models\ElectionType;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event = Event::create([
            'title' => 'School Year 2022-2023'
        ]);


        $departments = Department::all();
        $positions = ElectionType::find(ElectionType::TYPE_DSG)->positions;

        foreach ($departments as $department) {
            $election = Election::create([
                'election_type_id' => ElectionType::TYPE_DSG,
                'title' => $department->name . ' for ' . $event->title,
                'event_id' => $event->id,
                'department_id' => $department->id,
                'start_at' => now(),
                'end_at' => now()->addDays(3),
            ]);

            foreach ($positions as $position) {
                Candidate::factory(4)->create([
                    'position_id' => $position->id,
                    'election_id' => $election->id,
                ]);
            }
        }

        Event::factory()->includeEndedDsgElections()->create();
    }
}
