<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public function updatePassword(): void
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        Validator::make($this->state, [
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ])->after(function ($validator) use ($user) {
            if (! Hash::check($this->state['current_password'], $user->password)) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        })->validateWithBag('updatePassword');

        $user->update([
            'password' => Hash::make($this->state['password']),
        ]);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->dispatchBrowserEvent('toast-alert', [
            'type' => 'success',
            'message' => 'Your password has been updated.',
        ]);
    }

    public function render()
    {
        return view('livewire.profile.update-password-form');
    }
}
