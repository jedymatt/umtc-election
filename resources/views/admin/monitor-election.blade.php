<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitor Election
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <span class="text-2xl font-medium">{{ $election->title }}</span>
                    </div>
                    <div>
                        Status: {{ $election->statusMessage() }}
                    </div>

                </div>
            </div>
        </div>
        @if ($election->isEnded())
            <div class="mt-6"></div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <span class="text-lg font-medium">Winners</span>
                        <livewire:admin.elections.show-winners :election="$election" />
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-6"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium">Candidates</span>
                    <div class="mt-1">
                        <livewire:admin.monitor-election.show-candidates :election="$election" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
