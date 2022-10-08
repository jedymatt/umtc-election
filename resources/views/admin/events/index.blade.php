<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    @if ($events->isEmpty())
                        <div class="flex flex-col items-center justify-center">
                            <div>
                                <span class="text-lg font-medium text-gray-400">Empty Event</span>
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
                            <div x-data="{ open: @js($errors->has('title')) }">

                                <div
                                    class="mt-4"
                                    x-cloak
                                    x-show="open"
                                    x-collapse
                                    x-trap="open"
                                >
                                    <form
                                        action="{{ route('admin.events.store') }}"
                                        method="post"
                                    >
                                        @csrf

                                        <div>
                                            <x-label
                                                for="title"
                                                value="Create Event"
                                            />
                                            <x-input
                                                class="mt-1 block w-full"
                                                id="title"
                                                name="title"
                                                type="text"
                                                value="{{ old('title') }}"
                                                placeholder="Event Title"
                                                required
                                            />
                                            @error('title')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mt-4 flex justify-end gap-2">
                                            <button
                                                class="flex items-center rounded-md bg-primary-500 py-1 px-2 text-sm font-medium uppercase text-white hover:bg-primary-700"
                                            >
                                                Create
                                            </button>
                                            <button
                                                class="flex items-center rounded-md border border-primary-500 bg-primary-100 py-1 px-2 text-sm font-medium uppercase text-primary-500 hover:bg-primary-200"
                                                type="button"
                                                x-on:click="open = false"
                                            >
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div
                                    class="flex justify-end"
                                    x-show="!open"
                                    x-transition
                                >
                                    <button
                                        class="flex items-center rounded-md bg-primary-500 py-1 px-2 text-sm font-medium uppercase text-white hover:bg-primary-700"
                                        x-cloak
                                        x-on:click="open = !open"
                                    >
                                        Create Event
                                    </button>
                                </div>
                            </div>
                        @endif
                        <div class="mt-4"></div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                                            Created At
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
                                    @foreach ($events as $event)
                                        <tr class="border-b bg-white align-text-top hover:bg-gray-50">
                                            <th
                                                class="max-w-xs truncate whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                                scope="row"
                                            >
                                                {{ $event->title }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $event->created_at->diffForHumans() }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                                <a
                                                    class="font-medium text-blue-600 hover:underline"
                                                    href="{{ route('admin.events.show', $event) }}"
                                                >View</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="rounded-md bg-white py-4">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
