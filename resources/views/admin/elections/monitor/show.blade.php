<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitor Election
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div>
                        <span class="text-xl font-medium">{{ $election->title }}</span>
                    </div>
                    <div>
                        {{ $election->statusMessage() }}
                    </div>

                    <div class="mt-4">
                        <!-- component -->
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b-2 border-b-gray-300">
                                    <tr class="bg-gray-100">
                                        <th class="text-left p-4 font-medium">
                                            Name
                                        </th>
                                        <th class="text-left p-4 font-medium">
                                            Department
                                        </th>
                                        <th class="text-left p-4 font-medium">
                                            Votes
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($positions as $position)
                                        <tr class="border-b-2 border-l-8 border-l-primary border-b-gray-300">
                                            <td class="p-4" colspan="3">
                                                <span class="font-medium text-primary">{{ $position->name }}</span>
                                            </td>
                                        </tr>
                                        @forelse ($candidates->where('position_id', $position->id) as $candidate)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="p-4">
                                                    {{ $candidate->user->name }}
                                                </td>
                                                <td class="p-4">
                                                    {{ $candidate->user->department->name }}
                                                </td>
                                                <td class="p-4">
                                                    {{ $candidate->votes_count }}
                                                </td>
                                            </tr>

                                        @empty
                                        <tr class="border-b bg-gray-50">
                                            <td class="p-4" colspan="3">
                                                <span class="text-gray-400 italic">No Candidates</span>
                                            </td>
                                        </tr>
                                        @endforelse
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
