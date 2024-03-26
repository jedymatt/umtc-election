<div wire:poll>
    <h3 class="text-2xl font-semibold">Live Results</h3>
    <span class="text-sm text-gray-500">Last refreshed today at {{  now()->format('g:i:s a') }}</span>
    <div class="mt-6">
        <x-election.result :election="$election"/>
    </div>
</div>
