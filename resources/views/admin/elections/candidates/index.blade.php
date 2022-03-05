<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Election Candidates
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach($positions as $position)
                        <div class="px-4 py-1 border-b-gray-200 border-b py-5">
                            <h1 class="font-semibold">{{ $position->name }}</h1>
                            <livewire:admin.election.candidate.create
                                :election="$election"
                                :position="$position"
                            />
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
