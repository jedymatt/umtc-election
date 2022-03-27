<div>
    <div>
        <div>
            <label>
                <input wire:model="searchText" type="text" placeholder="Search using name or email">
            </label>
            <label>
                <select wire:model="selectedPositionId">
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}">
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>
            </label>
            <button type="button" wire:click.prevent="addCandidate">Add</button>
        </div>
        <div>

            @foreach($users as $user)
                <div>
                    <a href="#" wire:click.prevent="addCandidate({{ $user->id }})">
                        {{ $user->name }} ({{ $user->email }})
                    </a>
                </div>
            @endforeach
            <div>

            </div>
        </div>
    </div>
    <div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Name
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Position
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($candidates as $candidate)
                                <tr class="border-b">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $candidate['user_name'] }}
                                        <div class="font-light">
                                            {{ $candidate['user_email'] }}
                                        </div>
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{ $candidate['position_name'] }}
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        <button class="text-red-500 hover:underline" type="button"
                                                wire:click.prevent="removeCandidate({{ json_encode($candidate)  }})">
                                            Remove
                                        </button>
                                    </td>
                                <input type="hidden" name="candidates[{{ $loop->index }}][user_id]"
                                       value="{{ $candidate['user_id']  }}">
                                <input type="hidden" name="candidates[{{ $loop->index }}][position_id]"
                                       value="{{ $candidate['position_id'] }}">
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="max">Add Candidates</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
