<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="name" value="Name"/>
                        <x-input id="name" name="name" :value="$admin->name" type="text" disabled
                                 class="block mt-1 w-full"/>
                    </div>
                    <div class="mt-4">
                        <x-label for="email" value="Email"/>
                        <x-input id="email" name="email" :value="$admin->email" type="email" disabled
                                 class="block mt-1 w-full"/>
                    </div>
                    <div class="mt-4">
                        <x-label for="is_super_admin" value="Role"/>
                        <x-input id="is_super_admin" name="is_super_admin"
                                 :value="$admin->is_super_admin ? 'Super Administrator' : 'Administrator'" type="text"
                                 disabled
                                 class="block mt-1 w-full"/>
                    </div>
                    <div class="mt-4">
                        <x-label value="Assigned Department(s)"/>
                        <div class="block mt-1">
                            @foreach($admin->departments as $department)
                                <span
                                    class="px-2 p-1 inline-flex text-xs leading-5 font-semibold
                                    rounded-full bg-green-100 text-green-800 m-0.5">
                                    {{ $department->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
