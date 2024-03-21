<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        try {
            $this->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|confirmed|min:8',
            ]);
        } catch (ValidationException  $e) {
            $this->reset('state.password', 'state.password_confirmation', 'state.current_password');
            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('toast-alert',
            type: 'success',
            message: 'Your password has been updated.',
        );
    }

    public function render()
    {
        return view('livewire.profile.update-password-form');
    }
}
