<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($events->isEmpty())
                        <div class="flex flex-col justify-center items-center">
                            <div>
                                <span class="text-lg text-gray-400 font-medium">Empty Event</span>
                            </div>
                            @if(auth('admin')->user()->is_super_admin)
                                <div class="mt-4">
                                    <x-primary.button-link
                                        href="{{ route('admin.events.create') }}">Create Event
                                    </x-primary.button-link>
                                </div>
                            @endif
                        </div>
                    @else
                        @if(auth('admin')->user()->is_super_admin)
                            <div class="flex justify-end">
                                <x-primary.button-link href="{{ route('admin.events.create') }}">
                                    Create Event
                                </x-primary.button-link>
                            </div>
                        @endif
                        <div class="mt-4"></div>
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 font-medium">
                                        Title
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Last Modified
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                               class="hover:underline"
                                            >{{ $event->title }}</a>
                                        </td>
                                        <td class="p-4">
                                            {{ $event->updated_at }}
                                        </td>
                                        <td class="p-4">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                               class="hover:underline text-blue-500 hover:text-blue-800 focus:text-blue-800 visited:text-blue-800"
                                            >
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
