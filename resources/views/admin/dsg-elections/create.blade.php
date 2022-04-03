<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create DSG Election') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.dsg-elections') }}" method="post">
                        @csrf
                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                            <input type="text" id="title" name="title"
                                   class="w-full rounded-md" value="{{ old('title') }}"/>
                            @error('title')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="10"
                                      class="w-full rounded-md"
                            >{{ old('description') }}</textarea>
                        </div>
                        <div class="mt-4">
                            <label for="start_at" class="block font-medium text-sm text-gray-700">Start At</label>
                            <input type="datetime-local" id="start_at" name="start_at"
                                   class="rounded-md" value="{{ old('start_at') }}"/>

                            @error('start_at')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="end_at" class="block font-medium text-sm text-gray-700">End At</label>
                            <input type="datetime-local" id="end_at" name="end_at"
                                   class="rounded-md" value="{{ old('end_at') }}"/>
                            @error('end_at')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="text-sm font-medium text-gray-700" for="department_id">Department</label>
                            <select name="department_id" id="department_id" @selected(old('department_id'))
                            class="mt-1 w-full rounded-md">
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">
                                        <span>{{ $department->name }}</span>
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4 border-t border-gray-200">
                        </div>
                        <div class="mt-4">
                            <span class="text-xl font-medium text-primary">Candidates</span>
                            <div class="my-2">
                                <livewire:admin.dsg-election.add-candidates-form/>
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
