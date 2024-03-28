<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Candidates') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                @include('admin.elections.partials.tabs')
            </div>
        </div>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    {{-- Content --}}
                    <div class="mt-4 h-full min-h-[50vh]">
                        @livewire('admin.election.manage-candidates', ['election' => $election])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
