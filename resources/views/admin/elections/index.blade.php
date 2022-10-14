<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Elections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    {{-- Content --}}
                    <div class="flex justify-end">
                        <x-button-primary href="{{ route('admin.elections.create') }}">New Election</x-button-primary>
                    </div>
                    <div class="relative mt-4 min-h-[20rem] overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3"
                                        scope="col"
                                    >
                                        Title
                                    </th>
                                    <th
                                        class="px-6 py-3"
                                        scope="col"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3"
                                        scope="col"
                                    >
                                        Type
                                    </th>
                                    <th
                                        class="px-6 py-3"
                                        scope="col"
                                    >
                                        Department
                                    </th>
                                    <th
                                        class="px-6 py-3"
                                        scope="col"
                                    >
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($elections as $election)
                                    <tr
                                        class="border-b bg-white align-text-top hover:bg-gray-50"
                                        wire:loading.class='hidden'
                                    >
                                        <th
                                            class="max-w-xs truncate whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                            scope="row"
                                        >
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
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <a
                                                class="font-medium text-blue-600 hover:underline"
                                                href="{{ route('admin.elections.show', $election) }}"
                                            >View</a> |
                                            <a
                                                class="font-medium text-blue-600 hover:underline"
                                                href="{{ route('admin.monitor-election', $election) }}"
                                            >Monitor</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            class="h-64"
                                            colspan="5"
                                        >
                                            <p class="text-center text-gray-500">No elections found.</p>
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
</x-admin-app-layout>
