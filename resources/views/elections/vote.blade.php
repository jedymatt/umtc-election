<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Election Voting Form
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="py-6 sm:p-6 bg-white border-b border-gray-200">
                        <div class="px-4 sm:px-0">
                            <div class="text-4xl text-primary font-bold">
                                {{ $election->title }}
                            </div>
                            <div class="font-light mt-1 ">
                                @if($election->description)
                                    <p>{{ $election->description }}</p>
                                @else
                                    <div class="text-gray-500 italic mt-3">No description</div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 border-t sm:border-none">
                            <form action="{{ route('elections.vote', $election) }}" method="post">
                                @csrf
                                @foreach($candidatesByPositionName as $positionName => $candidates)
                                    <div class="px-4 sm:my-6 py-4 sm:rounded-md sm:border border-b">
                                        @error('candidates.'.$candidates[0]->position_id)
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <span class="font-bold text-lg text-primary">{{ $positionName }}</span>
                                        @foreach($candidates as $candidate)
                                            <div class="mt-2">
                                                <input id="candidates.{{$candidate->position_id}}.{{$candidate->id}}"
                                                       name="candidates[{{ $candidate->position_id }}]" type="radio"
                                                       class="text-primary"
                                                       value="{{ $candidate->id }}"/>
                                                <label
                                                    for="candidates.{{$candidate->position_id}}.{{$candidate->id}}">
                                                    {{ $candidate->user->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                <div class="flex justify-end mt-4 px-4 sm:px-0">
                                    <x-primary.button>Submit Vote</x-primary.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
