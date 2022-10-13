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
                        <span class="text-2xl font-bold">{{ $election->title }}</span>
                    </div>
                    <div>
                        Status: {{ $election->statusMessage() }}
                    </div>
                </div>
            </div>
        </div>
        @if ($election->isEnded())
            <div class="mt-6"></div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if($isPendingResult)
                            <div class="flex justify-between">
                                Pending result! Result has yet to be processed. Wait for at least 5 minutes...
                            </div>
                        @endif
                        @if(!$isPendingResult && $conflictedWinners->isNotEmpty())
                            <span class="font-semibold">Resolve conflict by selecting the final winners:</span>

                            <form action="{{ route('admin.elections.finalize-winners', $election) }}" method="post">
                                @csrf
                                @foreach($conflictedWinners as $positionName => $winners)
                                    <div class="mt-1">
                                        <span class="font-medium">{{ $positionName }}</span>
                                        @foreach($winners as $winner)
                                            <div>
                                                <label>
                                                    <input type="radio"
                                                           id="winners.{{ $winner->candidate->position_id }}.{{ $winner->id }}"
                                                           name="winners[{{ $winner->candidate->position_id}}]"
                                                           value="{{ $winner->id }}">
                                                    {{ $winner->candidate->user->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="mt-4 flex justify-end">
                                    <button role="button" type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-primary-500 rounded-md text-white focus:ring ring-primary-300 active:bg-primary-700 hover:bg-primary-700 focus:outline-none ring-opacity-50">
                                        Resolve
                                    </button>
                                </div>
                            </form>
                        @endif
                        @if(!$isPendingResult && $conflictedWinners->isEmpty())
                            <span class="font-semibold text-xl">Final Winners</span>
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
                                        <th class="text-left p-4 font-medium">
                                            Votes
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($winners as $winner)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-4">
                                                {{ $winner->candidate->user->name }}
                                            </td>
                                            <td class="p-4">
                                                {{ $winner->candidate->position->name }}
                                            </td>
                                            <td class="p-4">
                                                {{ $winner->candidate->user->department?->name }}
                                            </td>
                                            <td class="p-4">
                                                {{ $winner->votes }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a role="button"
                                   class="bg-primary focus:ring ring-primary-300 px-2 py-1 rounded-md text-white focus:outline-none"
                                   href="{{ route('admin.elections.winners.export-excel', $election) }}">
                                    Export as Excel
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-6"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-xl font-semibold">Candidates</span>
                    <div class="mt-1">
                        <livewire:admin.monitor-election.show-candidates :election="$election"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
