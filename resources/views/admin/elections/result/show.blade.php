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
                            <span class="font-bold text-lg text-primary">{{ $position->name }}</span>
                            @foreach($candidates->where('position_id', $position->id) as $candidate)
                                <div class="mt-2">
                                    {{ $candidate->user->name }}
                                    <div class="mt-1">
                                        <div class="bg-primary-200 rounded-full h-2">
                                            <div class="bg-primary-600 h-2 rounded-full flex justify-end"
                                                 style="width: 45%">
                                                <span class="mt-2">{{ $candidate->votes_count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="flex justify-end mt-4">
                        <x-primary.button type="button">Export Spreadsheet</x-primary.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
