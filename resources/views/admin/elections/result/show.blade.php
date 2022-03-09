<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Election Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach($positions as $position)
                        <div class="mt-4">
                            <span class="text-xl font-semibold">{{ $position->name }}</span>
                            @foreach($candidates->where('position_id', $position->id) as $candidate)
                                <div>
                                    {{$candidate->user->name}} - {{ $candidate->votes->count() }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>