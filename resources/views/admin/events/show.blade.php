<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">{{ $event->title }}</span>
                    <div>
                        DSG Elections: {{ $dsgElections->count() }} / 7
                    </div>
                    <div>
                        CDSG Election: {{ $cdsgElection != null ? '1' : '0' }} / 1
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">CDSG Election</span>
                   @if(auth()->user()->is_super_admin)
                        <div class="flex justify-end mt-4">
                            <x-primary.button-link href="{{ route('admin.events.cdsg-elections.create', $event) }}">
                                Create CDSG Election
                            </x-primary.button-link>
                        </div>
                   @endif
                    <div class="mt-4">
                        <!-- component -->
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                    <tr class="bg-gray-100 uppercase font-medium">
                                        <th class="text-left p-4">
                                            Title
                                        </th>
                                        <th class="text-left p-4">
                                            Status
                                        </th>
                                        <th class="text-left p-4">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($cdsgElection != null)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-4">
                                                <a href="{{ route('admin.elections.show', $cdsgElection) }}"
                                                    class="hover:underline">{{ $cdsgElection->title }}</a>
                                            </td>
                                            <td class="p-4">
                                                <span @class([
                                                    'inline-block text-sm lowercase rounded-full border p-1 px-2',
                                                    'border-green-500 bg-green-100 text-green-800' => $cdsgElection->isActive(),
                                                    'border-red-500 bg-red-100 text-red-800' => !$cdsgElection->isActive(),
                                                ])>
                                                    {{ $cdsgElection->statusMessage() }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                @if ($cdsgElection->hasConflictedWinners())
                                                    <div class="inline-flex items-center">
                                                        <x-icon.warning class="inline-block text-yellow-500" />
                                                        <a class="text-sm text-red-500 hover:underline hover:text-red-700"
                                                            href="{{ route('admin.monitor-election', $cdsgElection) }}">
                                                            <span class="pl-1">Resolve Winners'
                                                                Conflict</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <a class="text-sm text-white bg-primary px-2 py-1 rounded-md hover:bg-primary-700 focus:ring ring-primary-300 active:bg-primary-700 focus:outline-none"
                                                        role="button"
                                                        href="{{ route('admin.monitor-election', $cdsgElection) }}">
                                                        Monitor Election
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="border-b">
                                            <td class="p-4" colspan="3">
                                                <span class="flex justify-center text-gray-400">No record!</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">DSG Elections</span>
                    <div class="flex justify-end mt-4">
                        <x-primary.button-link href="{{ route('admin.events.dsg-elections.create', $event) }}">
                            Create DSG Election
                        </x-primary.button-link>
                    </div>
                    <div class="mt-4">
                        <!-- component -->
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                    <tr class="bg-gray-100 uppercase font-medium">
                                        <th class="text-left p-4">
                                            Title
                                        </th>
                                        <th class="text-left p-4">
                                            Status
                                        </th>
                                        <th class="text-left p-4">
                                            Department
                                        </th>
                                        <th class="text-left p-4">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($dsgElections as $election)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-4">
                                                <a href="{{ route('admin.elections.show', $election) }}"
                                                    class="hover:underline">
                                                    {{ $election->title }}
                                                </a>
                                            </td>
                                            <td class="p-4">
                                                <span
                                                    @class([
                                                        'inline-block text-sm lowercase rounded-full border p-1 px-2',
                                                        'border-green-500 bg-green-100 text-green-800' => $election->isActive(),
                                                        'border-red-500 bg-red-100 text-red-800' => !$election->isActive(),
                                                    ])>{{ $election->statusMessage() }}</span>
                                            </td>
                                            <td class="p-4">
                                                {{ $election->department?->name }}
                                            </td>
                                            <td class="p-4">
                                                @if ($election->hasConflictedWinners())
                                                    <div class="inline-flex items-center">
                                                        <x-icon.warning class="inline-block text-yellow-500" />
                                                        <a class="text-sm text-red-500 hover:underline hover:text-red-700"
                                                            href="{{ route('admin.monitor-election', $election) }}">
                                                            <span class="pl-1">Resolve Winners'
                                                                Conflict</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <a class="text-sm text-white bg-primary px-2 py-1 rounded-md hover:bg-primary-700 focus:ring ring-primary-300 active:bg-primary-700 focus:outline-none"
                                                        role="button"
                                                        href="{{ route('admin.monitor-election', $election) }}">
                                                        Monitor Election
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="border-b">
                                            <td class="p-4" colspan="4">
                                                <span class="flex justify-center text-gray-400">No records!</span>
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
