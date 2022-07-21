<?php

namespace App\Http\Livewire\Admin\CdsgElection;

use App\Models\Event;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class AddCandidatesForm extends Component
{
    public Collection $candidates;

    public $positions;

    public $searchText = '';

    public $selectedPositionId = null;

    public $selectedUserId = null;

    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->positions = Position::Cdsgelection()->get();
        $this->selectedPositionId = $this->positions->first()->id;
        $this->candidates = collect();
    }

    public function render()
    {
        $users = new LengthAwarePaginator([], 0, 5);
        if ($this->searchText != '') {
            $users = User::search($this->searchText)
                ->query(function (Builder $query) {
                    $users = $this->candidates->map(function ($candidate) {
                        return $candidate['user_id'];
                    });
                    $query->whereNotIn('id', $users)
                        ->whereHas('winner.election.event', function (Builder $query) {
                            $query->where('id', '=', $this->event->id);
                        });
                })
                ->paginate(5);
        }

        return view('livewire.admin.cdsg-election.add-candidates-form', compact('users'));
    }

    public function addCandidate(User $user)
    {
        $this->candidates->prepend([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,

            'position_id' => $this->selectedPositionId,
            'position_name' => $this->positions->where('id', $this->selectedPositionId)->first()->name,
        ]);
    }

    public function removeCandidate(array $candidate)
    {
        $this->candidates = $this->candidates->reject(function ($value, $key) use ($candidate) {
            return $value == $candidate;
        });
    }
}
