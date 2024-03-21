<?php

namespace App\Livewire\Profile;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateProfileInformationForm extends Component
{
    public $state = [];

    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->state['department_id'] ??= '';
    }

    public function updateProfileInformation()
    {
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.department_id' => 'required|integer|exists:departments,id',
        ], attributes: [
            'state.name' => 'name',
            'state.department_id' => 'department',
        ]);

        Auth::user()->update([
            'name' => $this->state['name'],
            'department_id' => $this->state['department_id'],
        ]);

        $this->dispatch('toast-alert',
            type: 'success',
            message: 'Your profile information has been updated.',
        );
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form', [
            'departments' => Department::orderBy('name')->get(),
        ]);
    }
}
