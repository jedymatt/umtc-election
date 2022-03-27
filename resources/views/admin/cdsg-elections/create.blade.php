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
                    <div class="text-xl font-medium text-primary mb-2">Election</div>
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
                            <x-label for="description" value="Description"/>
                            <x-textarea id="description" name="description"
                                        class="mt-1 w-full" :value="old('description')"/>
                        </div>
                        <div class="lg:grid lg:grid-cols-2 lg:gap-4">
                            <div class="mt-4">
                                <x-label for="start_at" value="Start At"/>
                                <x-input type="datetime-local" id="start_at" name="start_at"
                                         class="mt-1 w-full"/>
                                @error('start_at')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <x-label for="end_at" value="End At"/>
                                <x-input type="datetime-local" id="end_at" name="end_at"
                                         class="mt-1 w-full"/>
                                @error('end_at')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 border-t border-gray-200">
                        </div>
                        <div class="mt-4">
                            <span class="text-xl font-medium text-primary">Select DSG Elections</span>
                            @foreach($departments as $department)
                                <div x-data="{ open: true }" class="my-2">
                                    <button type="button" class="block text-left"
                                            @click="open=!open">
                                        {{ $department->name }}
                                        <svg x-show="open"
                                             xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        <svg x-show="!open"
                                             xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block"
                                             viewBox="0 0 20 20"
                                             fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="mt-1">
                                        @foreach($elections->where('department_id', $department->id) as $election)
                                            <div class="ml-2">
                                                <input id="elections.{{ $department->id }}.{{ $election->id }}"
                                                       type="radio"
                                                       name="elections[{{$department->id}}]"
                                                       value="{{$election->id}}"/>
                                                <label for="elections.{{ $department->id }}.{{ $election->id }}">
                                                    {{ $election->title }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @error('elections')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4 border-t border-gray-200">
                        </div>
                        <div class="mt-4">
                            <span class="text-xl font-medium text-primary">Add Candidates</span>
                            <div class="my-2">
                                <livewire:admin.cdsg-election.add-candidates-form />
                            </div>
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
