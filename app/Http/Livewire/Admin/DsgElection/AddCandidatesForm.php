<?php

namespace App\Http\Livewire\Admin\DsgElection;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class AddCandidatesForm extends Component
{
    public Collection $candidates;

    public Collection $positions;

    public int $selectedPosition;

    public string $search = '';

    public function mount()
    {
        $this->positions = Position::all();
        $this->selectedPosition = $this->positions->first()->id;
        $this->candidates = collect();
    }

    public function render()
    {
        $users = new LengthAwarePaginator([], 0, 5);
        if ($this->search != '') {
            $users = User::search($this->search)
                ->query(function (Builder $query) {
                    $users = $this->candidates->map(function ($candidate) {
                        return $candidate['user_id'];
                    });
                    $query->whereNotIn('id', $users);
                })
                ->paginate(5);
        }

        return view('livewire.admin.dsg-election.add-candidates-form', compact('users'));
    }

    public function addCandidate(User $user)
    {
        $this->candidates->prepend([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,

            'position_id' => $this->selectedPosition,
            'position_name' => $this->positions->where('id', $this->selectedPosition)->first()->name,
        ]);
    }

    public function removeCandidate(array $candidate)
    {
        $this->candidates = $this->candidates->reject(function ($value, $key) use ($candidate) {
            return $value == $candidate;
        });
    }
}
