<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create CDSG Election') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.cdsg-elections') }}" method="post">
                        @csrf
                        <div>
                            <x-label for="title" value="Title"/>
                            <x-input id="title" name="title"
                                     class="mt-1 w-full" type="text" :value="old('title')"/>
                            @error('title')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-label for="start_at" value="Start At"/>
                            <x-input type="datetime-local" id="start_at" name="start_at"/>
                            @error('start_at')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-label for="end_at" value="End At"/>
                            <x-input type="datetime-local" id="end_at" name="end_at"/>
                            @error('end_at')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4 border-t border-gray-200"></div>
                        <div class="mt-4">
                            <input type="hidden" name="elections">
                            @foreach($departments as $department)
                                <span>{{ $department->name }}</span>
                                <div>
                                    @foreach($department->endedDsgElections as $election)
                                        <div>
                                            <input id="elections[{{ $department->id }}][{{ $election->id }}]"
                                                   type="radio"
                                                   {{--                                                       name="elections[{{$department->id}}]"--}}
                                                   name="elections[{{$department->id}}][]"
                                                   value="{{$election->id}}"/>
                                            <label for="elections[{{ $department->id }}][{{ $election->id }}]">
                                                {{ $election->title }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            @error('elections')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end mt-4">
                            <x-button>Create</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
