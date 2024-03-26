<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Result') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                @include('admin.elections.partials.tabs')
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($election->isOngoing())
                        <livewire:admin.election.show-live-result :election="$election"/>
                    @endif
                    @if ($election->isUpcoming())
                        <div class="grid place-content-center">
                            <div class="text-center">
                                <div class="text-2xl font-semibold">Election has not started yet</div>
                                <div class="mt-4">
                                    <span class="text-gray-500">Election will start on</span>
                                    <span class="text-primary">{{ $election->start_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($election->isEnded())
                        <div>
                            <div class="text-2xl font-bold">Election has ended.</div>
                            <div class="mt-4">
                                @if($hasNoWinners)
                                    <div>
                                        <form action="{{ route('admin.elections.finalize-results', $election) }}"
                                              method="post">
                                            @csrf
                                            @if($tiedCandidates->count() > 0)
                                                <div class="text-xl font-semibold">Resolve Tied Candidates</div>

                                                <div class="mb-4 space-y-2">
                                                    @foreach($tiedCandidates as $position => $candidates)
                                                        <div>
                                                            <div
                                                                class="text-primary font-semibold text-lg">{{ $position }}</div>
                                                            @error('candidates')
                                                            <span class="text-red-600 text-sm ">{{ $message }}</span>
                                                            @enderror
                                                            <div class="mt-2 p-2 border rounded-md">
                                                                @foreach($candidates as $candidate)
                                                                    <div>
                                                                        <input type="radio"
                                                                               name="candidates[{{ $position }}]"
                                                                               value="{{ $candidate->id }}"
                                                                               id="candidate-{{ $position }}-{{ $candidate->id }}">
                                                                        <label
                                                                            for="candidate-{{ $position }}-{{ $candidate->id }}"
                                                                            class="ml-2"
                                                                        >
                                                                            {{ $candidate->user->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            @error("candidates.{$position}")
                                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div>
                                                <x-btn.primary type="submit">
                                                    Click here to finalize the result
                                                </x-btn.primary>
                                            </div>
                                        </form>
                                    </div>

                                @else
                                    <div class="mt-2 text-gray-500">Result has been finalized.</div>
                                    <div class="mt-2 mb-6">
                                        <a href="{{ route('admin.elections.export-result', $election) }}"
                                           class="text-primary underline">
                                            Download Result
                                        </a>
                                    </div>
                                @endif

                                <div x-data="{tab: 1}"
                                     class="mt-6 border-t pt-6"
                                >
                                    <div
                                        class="grid grid-flow-col-dense rounded-md overflow-clip border divide-y text-center sm:max-w-md">
                                        <div @click="tab = 1" class="px-4 py-2 cursor-pointer select-none"
                                             :class="tab === 1 ? 'bg-slate-900 text-white': 'hover:bg-slate-200'">
                                            Vote Results
                                        </div>

                                        <div @click="tab =2" class="px-4 py-2 cursor-pointer select-none"
                                             :class=" tab === 2 ? 'bg-slate-900 text-white': 'hover:bg-slate-200'">
                                            Winners
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div x-show="tab === 1">
                                            <x-election.result :election="$election"/>
                                        </div>
                                        <div x-show="tab === 2" x-cloak>
                                            <x-election.winners :election="$election"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
