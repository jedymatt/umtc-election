<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('user-profile.update') }}" method="post">
                        @csrf
                        <div>
                            <x-label value="Full Name"/>
                            <x-input type="text" :value="old('name') ?? $user->name"
                                     id="name" name="name"
                                     class="w-full mt-1"
                            />
                        </div>
                        <div class="mt-4">
                            <x-label value="Department"/>
                            <select name="department_id" id="department_id" class="w-full">
                                @foreach($departments as $department)
                                    <option value="{{ $department  }}"> {{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-label value="Year Level"/>
                            <select name="year_level_id" id="year_level_id">
                                @foreach($yearLevels as $yearLevel)
                                    <option value="{{ $yearLevel  }}"> {{ $yearLevel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-label value="Program"/>
                            <select name="program_id" id="program_id">
                                @foreach($programs as $program)
                                    <option value="{{ $program  }}"> {{ $program->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end items-center h-4">
                            <x-button>Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
