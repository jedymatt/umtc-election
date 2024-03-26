<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Election Information') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                @include('admin.elections.partials.tabs')
            </div>
        </div>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <div class="grid grid-cols-5 gap-y-4 gap-x-2 sm:gap-x-0">
                        <div class="col-span-full">
                            <span class="text-2xl font-bold">{{ $election->title }}</span>
                        </div>
                        <div class="text-gray-800">Type</div>
                        <div class="col-span-4">{{ $election->type->label() }}</div>
                        @if ($election->isTypeDsg())
                            <div class="text-gray-800">Department</div>
                            <div class="col-span-4">{{ $election->department->name }}</div>
                        @endif
                        <div class="text-gray-800">Schedule</div>
                        <div class="col-span-4 space-y-1">
                            <div>
                                @php
                                    if ($election->start_at->isSameDay($election->end_at)) {
                                        echo $election->start_at->format('F j, Y');
                                    } else {
                                        echo $election->start_at->format('F j, Y') . ' - ' . $election->end_at->format('F j, Y');
                                    }
                                @endphp
                            </div>
                            <div>
                                @php
                                    echo $election->start_at->format('g:i A') . ' - ' . $election->end_at->format('g:i A');
                                @endphp
                            </div>
                        </div>
                        @if ($election->description != null)
                            <div class="text-gray-800">Description</div>
                            <div class="col-span-4">
                                <p class="text-justify leading-normal">
                                    {{ $election->description }}
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <span class="text-lg font-medium text-primary">Candidates</span>
                    <div class="mt-4">
                        <div class="overflow-x-auto border-x border-t">
                            <table class="w-full table-auto">
                                <thead class="border-b">
                                <tr class="bg-gray-100">
                                    <th class="p-4 text-left font-medium">
                                        Name
                                    </th>
                                    <th class="p-4 text-left font-medium">
                                        Position
                                    </th>
                                    <th class="p-4 text-left font-medium">
                                        Department
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($candidates as $candidate)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            {{ $candidate->user->name }}
                                        </td>
                                        <td class="p-4">
                                            {{ $candidate->position->name }}
                                        </td>
                                        <td class="p-4">
                                            {{ $candidate->user->department?->name }}
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
