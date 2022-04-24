<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admins') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @can('create', \App\Models\Admin::class)
                        <div class="flex justify-end pb-4">
                            <a href="{{ route('admin.admins.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Create Admin Account</a>
                        </div>
                    @endcan
                    <!-- component -->
                    <div class="bg-white">

                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 font-medium">
                                        Name
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Role
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Department
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $admin)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            <span class="{{ $admin->id == auth('admin')->id() ? 'font-medium': '' }}">
                                                {{ $admin->name }}
                                            </span>
                                            <span class="block font-light text-gray-500 text-sm">{{ $admin->email }}</span>
                                        </td>
                                        <td class="p-4">
                                            {{ $admin->roleMessage() }}
                                        </td>
                                        <td class="p-4">
                                            {{ $admin->department?->name }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
