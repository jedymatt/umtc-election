<?php

namespace App\Http\Livewire\Profile;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateProfileInformationForm extends Component
{
    public $state = [];

    public $departments;

    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->departments = Department::orderBy('name')->get();
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.department_id' => 'required|exists:departments,id',
        ]);

        Auth::user()->update([
            'name' => $this->state['name'],
            'department_id' => $this->state['department_id'],
        ]);

        $this->dispatchBrowserEvent('toast-alert', [
            'type' => 'success',
            'message' => 'Your profile information has been updated.',
        ]);
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }
}
