<div>
    <div x-data="{ show: false }" class="inline-flex flex-row w-full gap-1 items-baseline">
        <div class="w-1/3">
            <select wire:model="selectedPositionId" class="rounded-md inline-block w-full mt-1 sm:mt-0">
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}">
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="relative w-full sm:w-2/3">
            <div class="sm:flex gap-4">
                <input x-on:click="show = true" x-on:click.away="show=false" wire:model="searchText" type="search"
                    placeholder="Search using name or email" class="rounded-md w-full inline-block">

            </div>
            <div x-show="show && $wire.searchText.length !== 0" class="my-2 absolute bg-white overflow-y-auto h-40 w-full">
                <div class="border rounded-md shadom-sm">
                    <ul>
                        @foreach ($users as $user)
                            <li class="border-b">
                                <a href="#" wire:click.prevent="addCandidate({{ $user->id }})"
                                    class="block hover:bg-gray-100 w-full px-4 py-2">
                                    {{ $user->name }}
                                    <span class="block text-xs text-gray-800">
                                        {{ $user->email }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-gray-600 text-sm px-4 border-b py-2">

                        @if ($users->isNotEmpty())
                            Showing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }}
                            users
                        @elseif($searchText != '')
                            No results
                        @endif
                    </div>
                </div>
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
                                            <div class="font-light text-gray-700">
                                                {{ $candidate['user_email'] }}
                                            </div>
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            {{ $candidate['position_name'] }}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                            <button class="text-red-500 hover:underline" type="button"
                                                wire:click.prevent="removeCandidate({{ json_encode($candidate) }})">
                                                Remove
                                            </button>
                                        </td>
                                        <input type="hidden" name="candidates[{{ $loop->index }}][user_id]"
                                            value="{{ $candidate['user_id'] }}">
                                        <input type="hidden" name="candidates[{{ $loop->index }}][position_id]"
                                            value="{{ $candidate['position_id'] }}">
                                    </tr>
                                @empty
                                    <tr class="border-b">
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap"
                                            colspan="3">
                                            <span class="flex justify-center">Empty Candidates</span>
                                        </td>
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
