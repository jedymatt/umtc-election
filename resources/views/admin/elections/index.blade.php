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

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Title
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Schedule
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Department
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($elections as $election)
                                <tr class="bg-white border-b hover:bg-gray-50 align-text-top">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap truncate max-w-xs">
                                        {{ $election->title }}
                                    </th>
                                    <td class="px-6 py-4">
                                         <span @class(['uppercase text-xs py-0.5 px-1 rounded-full border' ,
                                            'border-green-500 bg-green-100 text-green-800'=> $election->isActive(),
                                            'border-red-500 bg-red-100 text-red-800' => $election->isExpired(),
                                            'border-orange-500 bg-orange-100 text-orange-800' => $election->isPending(),
                                            ])>{{ $election->statusMessage() }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $election->electionType->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($election->isPending())
                                            Starts at: {{ $election->start_at->diffForHumans() }}
                                        @endif
                                        @if ($election->isActive())
                                            Ends at: {{ $election->end_at->diffForHumans() }}
                                        @endif
                                        @if ($election->isExpired())
                                            Expired at: {{ $election->end_at->longRelativeToNowDiffForHumans() }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $election->department?->name }}
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.elections.show', $election) }}"
                                           class="font-medium text-blue-600 hover:underline">View</a> |
                                        <a href="{{ route('admin.monitor-election', $election) }}"
                                           class="font-medium text-blue-600 hover:underline">Monitor</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white rounded-md py-4">
                        {{ $elections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
