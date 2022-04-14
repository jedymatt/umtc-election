<?php

namespace App\Listeners;

use App\Events\ElectionEnded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateWinners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ElectionEnded  $event
     * @return void
     */
    public function handle(ElectionEnded $event)
    {
        //
    }
}
