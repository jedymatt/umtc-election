<?php

namespace App\Livewire\Admin;

use App\Models\Election;
use Livewire\Component;
use Livewire\WithPagination;

class ShowElections extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.show-elections', [
            'elections' => Election::with(['department'])->paginate(10),
        ]);
    }
}
