<?php

namespace App\Livewire\Admin\Election;

use App\Models\Election;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowLiveResult extends Component
{
    #[Locked]
    public Election $election;

    public function mount(Election $election): void
    {
        $this->election = $election;
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.admin.election.show-live-result');
    }
}
