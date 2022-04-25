<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Elections
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <span class="text-2xl font-bold">Active Elections</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        @foreach($activeElections as $election)
                            <div class="rounded-md shadow-sm focus:ring border border-gray-200 p-6">
                                <a href="{{ route('elections.show', $election) }}"
                                   class="font-bold text-2xl hover:underline underline-offset-auto decoration-2 text-primary"
                                >{{ $election->title }}</a>
                                <div class="text-md mt-4">
                                    Deadline: {{ $election->end_at->toDayDateTimeString() }}
                                </div>
                                <div class="text-gray-600 mt-1">
                                    <span
                                        class="inline-block text-sm border rounded-full p-1 bg-gray-100">
                                        {{ $election->electionType->name }}
                                    </span>
                                    @if($election->department != null)
                                        <span class="inline-block text-sm border rounded-full p-1 my-1 bg-gray-100">
                                            {{ $election->department->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="pt-4">
                                    @if($userCanVoteActiveElections[$election->id])
                                        <x-primary.button-link href="{{ route('elections.vote.create', $election) }}">
                                            Vote
                                        </x-primary.button-link>
                                    @else
                                        <x-primary.button type="button" class="hover:bg-primary" disabled>
                                            Not Eligible to Vote
                                        </x-primary.button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 mt-4 py-4">
                        <span class="text-2xl font-bold">Past Elections</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        @forelse($endedElections as $election)
                            <div class="rounded-md shadow-sm focus:ring border border-gray-200 p-6">
                                <a href="{{ route('elections.show', $election) }}"
                                   class="font-bold text-2xl hover:underline underline-offset-auto decoration-2 text-primary"
                                >{{ $election->title }}</a>
                                <div class="text-md mt-4">
                                    Deadline: {{ $election->end_at->toDayDateTimeString() }}
                                </div>
                                <div class="text-gray-600 mt-1">
                                    <span
                                        class="inline-block text-sm border rounded-full p-1 bg-gray-100">
                                        {{ $election->electionType->name }}
                                    </span>
                                    @if($election->department != null)
                                        <span class="inline-block text-sm border rounded-full p-1 my-1 bg-gray-100">
                                            {{ $election->department->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="pt-4">
                                    @if($isPendingWinners[$election->id])
                                        <span class="flex items-center text-yellow-500">
                                            <x-icon.warning class="inline-block"/>
                                            Pending results
                                        </span>
                                    @else
                                        <a href="{{ route('elections.winners', $election) }}"
                                           class="p-2 hover:underline decoration-1 text-primary">
                                            View winners
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="h-7 col-span-2 flex justify-center">
                                <span class="italic text-gray-400">No past elections</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
