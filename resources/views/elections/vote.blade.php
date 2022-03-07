<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl">{{ $election->title }}</h1>
                    <form action="{{ route('elections.vote', $election) }}" method="post">
                        @csrf
                        @foreach($positions as $position)
                            <span class="font-bold">{{ $position->name }}</span>
                            <div>
                                @foreach($candidates->where('position_id', $position->id) as $candidate)
                                    <div>
                                        <input id="positions.{{$position->id}}.candidates.{{$candidate->id}}"
                                               name="positions[{{ $position->id }}].candidates[]" type="radio"
                                               value="{{ $candidate->id }}"/>
                                        <label
                                            for="positions.{{$position->id}}.candidates.{{$candidate->id}}">
                                            {{ $candidate->user->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="flex justify-end">
                            <x-button>Submit Vote</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
