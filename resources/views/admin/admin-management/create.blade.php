<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Admin Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
                    <form action="{{ route('admin.admin-management.store') }}" method="post">
                    @csrf
                    <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')"/>

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                     required autofocus/>
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')"/>

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                                     :value="old('email')" required/>
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')"/>

                            <x-input id="password" class="block mt-1 w-full"
                                     type="password"
                                     name="password"
                                     required autocomplete="new-password"/>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')"/>

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                     type="password"
                                     name="password_confirmation" required/>
                        </div>
                        <div class="mt-4">
                            <x-label for="department" value="Assigned Department"/>

                            @foreach($departments as $department)
                                <div class="mt-1">
                                    <input type="radio" value="{{ $department->id }}"
                                           id="department_id.{{ $department->id  }}" name="department_id"/>
                                    <label for="department_id.{{ $department->id }}">
                                        {{ $department->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-end mt-4">
                            <x-button>Create Admin Account</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
