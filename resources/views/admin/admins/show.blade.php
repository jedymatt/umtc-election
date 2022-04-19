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
                                 :value="$admin->roleMessage()" type="text"
                                 disabled
                                 class="block mt-1 w-full"/>
                    </div>
                    @if(!$admin->isSuperAdmin())
                        <div class="mt-4">
                            <x-label for="department" value="Department"/>
                            <x-input id="department" name="department" value="{{$admin->department->name}}" type="text"
                                     disabled
                                     class="block mt-1 w-full"/>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
