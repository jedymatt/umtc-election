<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Election Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-label for="title" value="Title"/>
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                                 :value="$election->title" disabled/>
                    </div>
                    <div class="mt-4">
                        <x-label for="description" value="Description"/>
                        <x-textarea id="description" name="description" rows="3"
                                    class="block mt-1 w-full" disabled>{{ $election->description }}</x-textarea>
                    </div>
                    <div class="mt-4">
                        <x-label for="start_at" value="Start At"/>
                        <x-input type="datetime-local" id="start_at" name="start_at" :value="$election->start_at"
                                 disabled/>
                    </div>
                    <div class="mt-4">
                        <x-label for="end_at" value="End At"/>
                        <x-input type="datetime-local" id="end_at" name="end_at" :value="$election->end_at" disabled/>
                    </div>

                    <div class="mt-4">
                        @foreach($positions as $position)
                            <div class="mt-2">
                                <table class="table-fixed border w-full">
                                    <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th scope="col" colspan="2" class="text-left py-2">
                                            {{ $position->name }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-left">
                                            Name
                                        </th>
                                        <th class="text-left">
                                            Department
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($candidates->where('position_id', '=', $position->id) as $candidate)
                                        <tr>
                                            <td>
                                                {{ $candidate->user->name }}
                                            </td>
                                            <td>
                                                {{ $candidate->user->department->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
