<?php

namespace App\Console\Commands;

use App\Models\Election;
use App\Services\ElectionService;
use Illuminate\Console\Command;

class StoreElectionWinners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:save-winners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store winners of ended elections';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $elections = Election::query()
            ->ended()
            ->whereHas('candidates')
            ->whereDoesntHave('winners')
            ->get();

        if ($elections->isEmpty()) {
            $this->info('No elections to save winners!');
            info('No elections to save winners!');

            return 1;
        }

        foreach ($elections as $election) {
            (new ElectionService($election))->saveWinners();
        }

        $this->info('Winners of each elections saved successfully!');
        info('Winners of each elections saved successfully!');

        return 0;
    }
}
