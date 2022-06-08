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
                    <div x-data="{open: @js($errors->has('title')) }">
                        <div class="flex justify-end">
                            <button x-cloak x-on:click="open = !open" class="flex items-center bg-primary-500 uppercase text-white text-sm font-medium py-1 px-2 rounded-md hover:bg-primary-700"><span x-text="open ? 'Cancel' : 'Create Event'" x-transition.scale></span></button>
                        </div>
                        <div x-cloak x-show="open" x-collapse class="mt-4" x-trap="open">
                            <form action="{{ route('admin.events.store') }}" method="post">
                                @csrf

                                <div>
                                    <x-label for="title" value="Event Title" />
                                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}" required/>
                                    @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-4 flex justify-end">
                                <button  class="flex items-center bg-primary-500 uppercase text-white text-sm font-medium py-1 px-2 rounded-md hover:bg-primary-700">
                                    Create
                                </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    <div class="mt-4"></div>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created At
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr class="bg-white border-b hover:bg-gray-50 align-text-top">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap truncate max-w-xs">
                                        {{ $event->title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $event->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.events.show', $event) }}" class="font-medium text-blue-600 hover:underline">View</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white rounded-md py-4">
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
