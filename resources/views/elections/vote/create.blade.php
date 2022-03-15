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
                    <div class="mt-4">
                        <form action="{{ route('elections.vote', $election) }}" method="post">
                            @csrf
                            <input type="hidden" name="candidates[]">
                            @error('candidates')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @foreach($positions as $position)
                                <div class="mt-4">
                                    <span class="font-bold text-lg text-primary">{{ $position->name }}</span>
                                    @foreach($candidates->where('position_id', $position->id) as $candidate)
                                        <div class="mt-2 sm:pl-6">
                                            <input id="positions.{{$position->id}}.candidates.{{$candidate->id}}"
                                                   name="candidates[{{ $position->id }}]" type="radio"
                                                   class="text-primary"
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
                                <x-primary.button>Submit Vote</x-primary.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
