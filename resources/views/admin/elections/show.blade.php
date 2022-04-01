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
                        <span class="text-lg font-medium">{{ $election->title }}</span>
                    </div>
                    <div class="mt-4">
                        Type: {{ $election->electionType->name }}
                    </div>
                    <div class="mt-4">
                        Department: {{ $election->department->name }}
                    </div>
                    <div class="mt-4">
                        Start at: {{ $election->start_at->toDayDateTimeString() }}
                    </div>
                    <div class="mt-4">
                        End at: {{ $election->end_at->toDayDateTimeString() }}
                    </div>
                    <div class="mt-4">
                        <p class="text-justify leading-normal">
                            @if($election->description != null)
                                {{ $election->description }}
                            @else
                                <span class="italic text-gray-600">No Description</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6">

        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">Candidates</span>
                    <div class="mt-4">
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 font-medium">
                                        Name
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Position
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Department
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($candidates as $candidate)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            {{ $candidate->user->name }}
                                        </td>
                                        <td class="p-4">
                                            {{ $candidate->position->name }}
                                        </td>
                                        <td class="p-4">
                                            {{ $candidate->user->department->name }}
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

</x-admin-app-layout>
