<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Election Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <div>
                        <span class="text-lg font-medium">{{ $election->title }}</span>
                    </div>
                    <div class="mt-4">
                        Type: {{ $election->electionType->name }}
                    </div>
                    @if ($election->election_type_id == \App\Models\ElectionType::TYPE_DSG)
                        <div class="mt-4">
                            Department: {{ $election->department->name }}
                        </div>
                    @endif
                    <div class="mt-4">
                        Start at: {{ $election->start_at->toDayDateTimeString() }}
                    </div>
                    <div class="mt-4">
                        End at: {{ $election->end_at->toDayDateTimeString() }}
                    </div>
                    <div class="mt-4">
                        Related Links:
                        <a
                            class="text-blue-600 underline"
                            href="{{ route('admin.monitor-election', $election) }}"
                        >
                            Monitor Election
                        </a>
                    </div>
                    @if ($election->description != null)
                        <div class="mt-4">
                            <p class="text-justify leading-normal">
                                {{ $election->description }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-6"></div>
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
