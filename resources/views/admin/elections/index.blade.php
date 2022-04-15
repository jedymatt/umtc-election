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
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 font-medium">
                                        Title
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Status
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Type
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Department
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Actions
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($elections as $election)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            <span class="truncate">{{ $election->title }}</span>
                                        </td>
                                        <td class="p-4">
                                            {{ $election->electionType->name }}
                                        </td>
                                        <td class="p-4">
                                            {{ $election->statusMessage() }}
                                        </td>
                                        <td class="p-4">
                                            {{ $election->department->name }}
                                        </td>
                                        <td class="p-4">
                                            <a class="text-primary hover:underline hover:text-primary-700 visited:text-primary-700"
                                               href="{{ route('admin.elections.show', $election) }}">Details</a>
                                            <div class="mt-2">
                                                <a class="text-white bg-primary px-2 py-1 rounded-md hover:bg-primary-700 focus:ring ring-primary-300 active:bg-primary-700 focus:outline-none"
                                                   role="button"
                                                   href="{{ route('admin.monitor-election', $election) }}">Monitor</a>
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
