@props(['election'])

<div class="rounded-md bg-white border-2 border-primary-400 p-4 max-w-lg">
    <h1 class="text-2xl font-bold text-primary-500">{{ $election->title }}</h1>
    <div class="mt-4">
        Deadline: {{ $election->end_at->toDayDateTimeString() }}
    </div>
    <div class="mt-4 flex justify-end">
        <x-button-primary href="{{ route('elections.vote', $election) }}">
            Vote
        </x-button-primary>
    </div>
</div>
