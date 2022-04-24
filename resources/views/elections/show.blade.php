<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Election Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-4xl text-primary font-bold">
                        {{ $election->title }}
                    </div>
                    <div class="text-sm text-gray-500 italic">
                        <div class="sm:inline-block">
                            Type: {{ $election->electionType->name }}
                        </div>
                        <div class=" sm:inline-block sm:ml-2">
                            Status: {{ $election->statusMessage() }}
                        </div>
                        <div class=" sm:inline-block sm:ml-2">
                            Deadline: {{ $election->end_at->toDayDateTimeString() }}
                        </div>
                    </div>
                    <div class="font-light mt-1 ">
                        @if($election->description)
                            {{ $election->description }}
                        @else
                            <div class="text-gray-500 italic mt-3">No description</div>
                        @endif
                    </div>
                    <div class="mt-10">
                        @if(!$election->hasVotedByUser(Auth::user()) and $election->isActive())
                            <a class="text-primary hover:underline decoration-1"
                               href="{{ route('elections.vote.create', $election) }}">Go to vote page
                                <x-link-logo class="w-3.5 h-3.5 inline"/>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
