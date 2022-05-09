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
                    @if (!$isCompleteUserInfo)
                        <div class="mb-4 rounded-md shadow-md p-4 border border-gray-100">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="ml-1 font-medium">Your profile information needs to be updated!</span>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('user-profile') }}"
                                   class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-900 focus:outline-none focus:border-primary-900 focus:ring ring-primary-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Go to Profile
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-1" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>

                            </div>
                        </div>
                    @endif
                    <div>
                        <span class="text-2xl font-bold">Active Elections</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        @foreach ($activeElections as $election)
                            <div class="rounded-md shadow-sm focus:ring border border-gray-200 p-6">
                                <a href="{{ route('elections.show', $election) }}"
                                   class="font-bold text-2xl hover:underline underline-offset-auto decoration-2 text-primary">{{ $election->title }}</a>
                                <div class="text-md mt-4">
                                    Deadline: {{ $election->end_at->toDayDateTimeString() }}
                                </div>
                                <div class="text-gray-600 mt-1">
                                    <span class="inline-block text-sm border rounded-full p-1 bg-gray-100">
                                        {{ $election->electionType->name }}
                                    </span>
                                    @if ($election->department != null)
                                        <span class="inline-block text-sm border rounded-full p-1 my-1 bg-gray-100">
                                            {{ $election->department->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="pt-4">
                                    @if ($userCanVoteActiveElections[$election->id])
                                        <x-primary.button-link href="{{ route('elections.vote', $election) }}">
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
                        @forelse($pastElections as $election)
                            <div class="rounded-md shadow-sm focus:ring border border-gray-200 p-6">
                                <a href="{{ route('elections.show', $election) }}"
                                   class="font-bold text-2xl hover:underline underline-offset-auto decoration-2 text-primary">{{ $election->title }}</a>
                                <div class="text-md mt-4">
                                    Deadline: {{ $election->end_at->toDayDateTimeString() }}
                                </div>
                                <div class="text-gray-600 mt-1">
                                    <span class="inline-block text-sm border rounded-full p-1 bg-gray-100">
                                        {{ $election->electionType->name }}
                                    </span>
                                    @if ($election->department != null)
                                        <span class="inline-block text-sm border rounded-full p-1 my-1 bg-gray-100">
                                            {{ $election->department->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="pt-4">
                                    @if ($isPendingWinners[$election->id])
                                        <span class="flex items-center text-yellow-500">
                                            <x-icon.warning class="inline-block"/>
                                            Pending result
                                        </span>
                                    @else
                                        <a href="{{ route('elections.result', $election) }}"
                                           class="p-2 hover:underline decoration-1 text-primary">
                                            View result
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
