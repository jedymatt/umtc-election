<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Election Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach($positions as $position)
                        <div class="mt-4">
                            <span class="font-bold text-lg text-primary">{{ $position->name }}</span>
                            <div class="mt-2 overflow-x-auto border-x border-t">
                                <table class="table-auto w-full">
                                    <thead class="border-b">
                                    <tr class="bg-gray-100">
                                        <th class="text-left p-4 font-medium">
                                            Name
                                        </th>
                                        <th class="text-left p-4 font-medium">
                                            Votes
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($candidates->where('position_id', '=', $position->id) as $candidate)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-4">
                                                {{ $candidate->user->name }}
                                            </td>
                                            <td class="p-4">
                                                {{ $candidate->votes_count }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
