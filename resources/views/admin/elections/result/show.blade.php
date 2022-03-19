<x-admin-app-layout>
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
                            <div class="mt-2">
                                <div class="flex flex-col">
                                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="overflow-hidden">
                                                <table class="min-w-full border table-auto">
                                                    <thead class="border-b bg-gray-50">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-6 py-4 text-left">
                                                            Name
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-4 text-left">
                                                            Number of Votes
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($candidates->filter(function ($candidate) use($position) { return $candidate->position_id == $position->id; }) as $candidate)
                                                        <tr class="border-b">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                {{ $candidate->user->name }}
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                {{ $candidate->votes_count }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end mt-4">
                        <x-primary.button-link href="{{ route('admin.elections.result.export-excel', $election) }}">Export Excel</x-primary.button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
