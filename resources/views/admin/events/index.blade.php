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
                    @if ($events->isEmpty())
                        <div class="flex flex-col justify-center items-center">
                            <div>
                                <span class="text-lg text-gray-400 font-medium">Empty Event</span>
                            </div>
                            @if (auth('admin')->user()->is_super_admin)
                                <div class="mt-4">
                                    <x-primary.button-link href="{{ route('admin.events.create') }}">
                                        Create Event
                                    </x-primary.button-link>
                                </div>
                            @endif
                        </div>
                    @else
                        @if (auth('admin')->user()->is_super_admin)
                            <div class="flex justify-end">
                                <x-primary.button-link href="{{ route('admin.events.create') }}">
                                    Create Event
                                </x-primary.button-link>
                            </div>
                        @endif
                        <div class="mt-4"></div>
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-fixed w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100 uppercase font-medium">
                                    <th class="text-left py-2 px-4 w-3/4">
                                        Title
                                    </th>
                                    <th class="text-left py-2 px-4">
                                        Created At
                                    </th>
                                    {{-- <th class="text-left py-2 px-4 font-medium">
                                        Actions
                                    </th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($events as $event)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4 truncate">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                               class="hover:underline">

                                                {{ $event->title }}

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4 inline-block text-gray-400" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="py-2 px-4">
                                            {{ $event->created_at->diffForHumans() }}
                                        </td>
                                        {{-- <td class="py-2 px-4">
                                            <a href="{{ route('admin.events.show', $event) }}"
                                                class="hover:underline text-blue-500 hover:text-blue-800 focus:text-blue-800 visited:text-blue-800">
                                                View
                                            </a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
