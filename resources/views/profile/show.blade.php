<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        @livewire('profile.update-profile-information-form')

                    <div class="border-t mt-6 pt-6">
                        @livewire('profile.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
