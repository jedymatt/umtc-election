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
                    <form action="{{ route('user-profile') }}" method="post">
                        @method('put')
                        @csrf
                        <div>
                            <x-label value="Full Name" />
                            <x-input type="text" :value="$user->name" id="name" name="name" class="w-full mt-1"
                                required />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <x-label value="Email Address" />
                            <x-input type="email" :value="$user->email"
                                class="select-none w-full mt-1 text-gray-600 hover:cursor-not-allowed" disabled />
                        </div>
                        <div class="mt-4">
                            <x-label value="Department" />
                            <select name="department_id" id="department_id"
                                class="mt-1 w-full sm:w-1/2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @if ($user->department_id == null)
                                    <option selected disabled>
                                        -- Select department --
                                    </option>
                                @endif
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected($department->id == $user->department_id)>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-end items-center mt-4">
                            <x-button>Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
