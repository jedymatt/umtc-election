<div>
    <div class="flex flex-row justify-between items-baseline gap-4">
        <div class="flex-grow flex flex-row items-baseline gap-4">
            <span>Event</span>
            @livewire('admin.select-event')
        </div>
        <x-button-primary href="{{ route('admin.elections.create') }}">New Election</x-button-primary>
    </div>
    <div class="mt-4 relative overflow-x-auto shadow-md sm:rounded-lg">
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
                        Department
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($elections as $election)
                    <tr class="bg-white border-b hover:bg-gray-50 align-text-top" wire:loading.class='hidden'>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap truncate max-w-xs">
                            {{ $election->title }}
                        </th>
                        <td class="px-6 py-4">
                            <span @class([
                                'uppercase text-xs py-0.5 px-1 rounded-full border',
                                'border-green-500 bg-green-100 text-green-800' => $election->isActive(),
                                'border-red-500 bg-red-100 text-red-800' => $election->isExpired(),
                                'border-orange-500 bg-orange-100 text-orange-800' => $election->isPending(),
                            ])>{{ $election->statusMessage() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $election->electionType->name }}
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
</div>
