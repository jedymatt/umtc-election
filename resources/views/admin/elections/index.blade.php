<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Elections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    {{-- Content --}}
                    <div class="flex justify-end">
                        <x-button-primary href="{{ route('admin.elections.create') }}">New Election</x-button-primary>
                    </div>
                    <div class="mt-4">
                        @livewire('admin.show-elections')

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
