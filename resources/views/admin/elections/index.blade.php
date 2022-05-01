<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Elections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- component -->
                    <div class="bg-white">

                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100 uppercase font-medium">
                                    <th class="text-left py-2 px-4">
                                        Title
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Status
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Type
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Department
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Actions
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($elections as $election)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">
                                            <span class="truncate">{{ $election->title }}</span>
                                        </td>
                                        <td class="py-2 px-4">
                                            <span  @class([
                                                'inline-block text-sm lowercase rounded-full border p-1 px-2',
                                                'border-green-500 bg-green-100 text-green-800' => $election->isActive(),
                                                'border-red-500 bg-red-100 text-red-800' => !$election->isActive(),
                                            ])>
                                            {{ $election->statusMessage() }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4">
                                            {{ $election->electionType->name }}
                                        </td>
                                        <td class="py-2 px-4">
                                            {{ $election->department?->name }}
                                        </td>
                                        <td class="py-2 px-4">
                                            <a class="text-primary hover:underline hover:text-primary-700 visited:text-primary-700"
                                               href="{{ route('admin.elections.show', $election) }}">Details</a>
                                            <div class="mt-2">
                                                <a class="text-white bg-primary px-2 py-1 rounded-md hover:bg-primary-700 focus:ring ring-primary-300 active:bg-primary-700 focus:outline-none"
                                                   role="button"
                                                   href="{{ route('admin.monitor-election', $election) }}">Monitor
                                                    Election</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $elections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
