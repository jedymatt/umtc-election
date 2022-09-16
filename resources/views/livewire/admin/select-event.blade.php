<div x-data="{ isOpen: false }" class="relative w-full" x-on:click.away="isOpen=false" x-trap.noreturn="isOpen"
    @keydown.right="$focus.next()" @keydown.left="$focus.previous()">
    <button x-on:click="isOpen = !isOpen"
        class="w-full relative rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2 pr-10 cursor-default focus:outline-none sm:text-sm bg-white border">
        <span class="flex items-center">
            @if ($selectedEvent !== null)
                <span class="ml-2 block">{{ $selectedEvent->title }}</span>
            @else
                <span class="ml-2 block text-gray-500">No event selected</span>
            @endif
        </span>
        <span class="absolute inset-y-0 right-0 inline-flex items-center ml-2 pr-2">
            <x-icon.selector-solid-icon />
        </span>
    </button>
    <div x-show="isOpen" style="display: none" class="mt-2 absolute w-full z-50">
        <div class="w-full py-2 rounded-md shadow-sm border bg-white">
            <div class="px-2 w-full">
                <x-input x-focus class="block w-full" type="text" wire:model.debounce.500ms="searchText"
                    placeholder="Search events.." />
            </div>
            <div class="max-h-48 border-t mt-2 overflow-y-scroll">
                @foreach ($events as $event)
                    <button x-on:click="$wire.selectEvent({{ $event->id }});isOpen = false"
                        class="p-2 w-full text-left block text-sm select-none hover:bg-blue-600 hover:text-white focus:bg-blue-600 focus:text-white">
                        {{ $event->title }}
                    </button>
                @endforeach
            </div>
        </div>

    </div>
</div>
