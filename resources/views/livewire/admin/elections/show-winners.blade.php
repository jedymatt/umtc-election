<div>
    @if($showWinners)
        <div>
            <span>  Resolve conflict by selecting the winners</span>
            @foreach($winnersConflicts as $positionName => $winners)
                <div class="mt-1">

                    <span>{{ $positionName }}</span>

                    @foreach($winners as $winner)
                        <div wire:key="{{ $loop->index }}">
                            <label>
                                <input type="radio"
                                       wire:model="selectedWinners.{{ $winner['candidate']['position_id'] }}"
                                       name="winners[{{ $winner['candidate']['position_id'] }}]"
                                       value="{{ $winner['id'] }}">
                                {{ $winner['candidate']['user']['name'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="mt-4 flex justify-end">
                <button role="button" wire:click.prevent="resolveConflict"
                        class="inline-flex items-center px-3 py-1 bg-primary-500 rounded-md text-white focus:ring ring-primary-300 active:bg-primary-700 hover:bg-primary-700 focus:outline-none ring-opacity-50">
                    Resolve
                </button>
            </div>
        </div>
    @else
        <div>
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
                                {{ $winner->candidate->user->department->name }}
                            </td>
                            <td class="p-4">
                                {{ $winner->votes }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <a role="button"
               class="bg-primary focus:ring ring-primary-300 px-2 py-1 rounded-md text-white focus:outline-none"
               href="{{ route('admin.elections.winners.export-excel', $election) }}">Export as Excel</a>
        </div>
    @endif
</div>
