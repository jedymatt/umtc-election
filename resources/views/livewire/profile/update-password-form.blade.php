<div>
    <div class="text-lg font-medium col-span-3">
        Update Password
    </div>
    <div class="mt-4">
        <form wire:submit="updatePassword">
            <div class="max-w-md">
                <x-label value="Current Password"/>
                <x-input class="mt-1 w-full" type="password" wire:model="current_password"
                         autocomplete="current-password"/>
                @error('current_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>
            <div class="mt-4 max-w-md">
                <x-label value="New Password"/>
                <x-input class="mt-1 w-full" type="password" wire:model="password" autocomplete="new-password"/>
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4 max-w-md">
                <x-label value="Confirm Password"/>
                <x-input class="mt-1 w-full" type="password" wire:model="password_confirmation"
                         autocomplete="new-password"/>
                @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>
            <div class="mt-4 flex justify-end">
                <x-button wire:loading.attr="disabled">
                    {{ __('Update Password') }}
                </x-button>
            </div>
        </form>
    </div>
</div>
