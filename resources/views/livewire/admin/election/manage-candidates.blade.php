<div>
    <div class="flex flex-row">
        <select wire:model.defer="selectedPositionId">
            @foreach ($positions as $position)
                <option value="{{ $position->id }}">
                    {{ $position->name }}
                </option>
            @endforeach
        </select>
        <div class="relative flex-grow">
            <input
                class="w-full"
                type="search"
                placeholder="Select a candidate"
                wire:model.debounce="searchText"
            />

            <div
                class="absolute inset-x-0 top-0 z-20 mt-12 max-h-52 w-full overflow-clip overflow-y-scroll rounded-md border bg-white shadow-lg"
                x-data="{ open: @entangle('showResults') }"
                x-show="open"
                wire:show="searchText"
            >
                <div class="py-1">
                    @foreach ($results as $user)
                        <div
                            class="cursor-pointer px-4 py-1 hover:bg-slate-200"
                            tabindex="1"
                            wire:click="selectUserFromResults({{ $user->id }})"
                        >
                            {{ $user->name }}
                            <div class="text-xs text-slate-800">
                                {{ $user->email }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div>
        <table class="w-full table-auto">
            <tbody>
            @foreach ($candidates as $candidate)
                <tr class="not-last:border-b">
                    <td class="py-2">
                        <span class="font-medium">{{ $candidate->user->name }}</span>
                        <div class="text-xs text-slate-800">
                            {{ $candidate->user->email }}
                        </div>
                    </td>
                    <td>
                        {{ $candidate->position->name }}
                    </td>
                    <td>
                        <button
                            class="inline-flex flex-row items-center justify-center gap-1 rounded-full bg-red-600 px-2 py-1 text-white shadow-sm"
                            type="button"
                            wire:click="removeCandidate({{ $candidate->id }})"
                            wire:loading.attr="disabled"
                        >

                            <span class="text-xs tracking-wide">Remove</span>
                            <svg
                                class="h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"
                                />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
