<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @can('create', \App\Models\Admin::class)
                        <div class="flex justify-end pb-4">
                            <a href="{{ route('admin.admin-management.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Create Admin Account</a>
                        </div>
                    @endcan
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b uppercase font-medium">
                                <tr class="b">
                                    <th class="text-left py-2 px-4">
                                        Name
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Role
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Department
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($admins as $admin)
                                    <tr
                                        class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">
                                                <span @class([
                                                    'font-medium' => $admin->id == auth('admin')->id(),
                                                ])>
                                                    {{ $admin->name }}
                                                </span>
                                            @if (auth()->id() == $admin->id)
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6 inline-block text-green-500"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"/>
                                                </svg>
                                            @endif
                                            <span
                                                class="block font-light text-gray-500 text-sm">{{ $admin->email }}</span>
                                        </td>
                                        <td class="py-2 px-4">
                                                <span @class([
                                                    'inline-block text-sm lowercase rounded-full border p-1 px-2',
                                                    'border-yellow-500 bg-yellow-100 text-yellow-800' => $admin->is_super_admin,
                                                    'border-red-500 bg-red-100 text-red-800' => !$admin->is_super_admin,
                                                ])>
                                                    {{ $admin->roleMessage() }}
                                                </span>
                                        </td>
                                        <td class="py-2 px-4">
                                            {{ $admin->department?->name }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $admins->links() }}
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
