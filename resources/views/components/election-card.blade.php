@props(['election', 'disableVote' => false])

<div class="rounded-md shadow-sm focus:ring border border-gray-200 p-6 flex flex-col">
    <div class="flex-grow">
        <div class="font-bold text-2xl text-primary">
            {{ $election->title }}
        </div>
        <div class="text-md mt-4">
            Deadline: {{ $election->end_at->toDayDateTimeString() }}
        </div>
        <div class="text-gray-600 mt-1">
            <span class="inline-block text-sm border rounded-full p-1 bg-gray-100">
                {{ $election->electionType->name }}
            </span>
            @if ($election->department != null)
                <span class="inline-block text-sm border rounded-full p-1 my-1 bg-gray-100">
                    {{ $election->department->name }}
                </span>
            @endif
        </div>
    </div>
    <div class="pt-4 flex justify-end">
        <x-button-primary href="{{ route('elections.vote', $election) }}" :disabled="$disableVote">
            Vote
        </x-button-primary>
    </div>
</div>
