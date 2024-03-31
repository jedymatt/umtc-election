<?php

namespace Tests\Feature\Admin;

use App\Exports\ElectionWinnersExport;
use App\Models\Admin;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Position;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExportResultTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_admin_can_download_results(): void
    {
        Excel::fake();
        Excel::matchByRegex();

        $user = Admin::factory()->create();
        $election = Election::factory()
            ->dsg()
            ->ended()
            ->has(
                Candidate::factory(25)
                    ->sequence(
                        ...Position::all()
                            ->map(fn (Position $position) => ['position_id' => $position->id])
                            ->toArray()
                    )
            )
            ->has(Vote::factory(100))
            ->create(['title' => 'Example Election']);

        $candidatesPerPosition = $election->candidates()->withCount('votes')->get()
            ->groupBy('position_id')
            ->map(fn ($candidates) => $candidates->first());

        $election->winners()->sync($candidatesPerPosition->map(fn ($candidate) => [
            'candidate_id' => $candidate->id,
            'votes' => $candidate->votes_count,
        ]));


        $this->actingAs($user, 'admin')
            ->get(route('admin.elections.export-result', $election));

        // timestamp regex pattern
        $pattern = '/election_'.str($election->title)->slug('_').'_\d+\.xlsx/';

        Excel::assertDownloaded($pattern, function (ElectionWinnersExport $export) use ($election) {
            return $export->collection()->contains($election->winners()->first());
        });

    }
}
