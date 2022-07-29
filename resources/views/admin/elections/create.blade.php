<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Election') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <div class="flex flex-row justify-center items-baseline gap-4">
                            <div class="flex-grow flex flex-row items-baseline gap-4">
                                <span class="block">Select Event</span>
                                @livewire('admin.select-event')
                            </div>
                            {{-- TODO: Show modal to create new event.--}}
                            <x-button-primary x-on:click="alert('create event modal')">
                                New Event
                            </x-button-primary>
                        </div>
                        <span class="mt-4 block font-medium text-lg">Select Election Type:</span>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <div class="flex items-center pl-4 rounded border border-gray-200">
                                <input id="bordered-radio-1" type="radio" value="" name="bordered-radio"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <label for="bordered-radio-1"
                                       class="py-4 ml-2 w-full text-sm font-medium text-gray-900">DSG</label>
                            </div>

                            <div class="flex items-center pl-4 rounded border border-gray-200">
                                <input checked id="bordered-radio-2" type="radio" value="" name="bordered-radio"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <label for="bordered-radio-2"
                                       class="py-4 ml-2 w-full text-sm font-medium text-gray-900 ">CDSG</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
