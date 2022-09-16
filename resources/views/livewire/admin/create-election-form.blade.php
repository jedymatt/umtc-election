<div>
    <div class="flex flex-row items-baseline justify-center gap-4">
        <span class="block">Select Event</span>
        <div class="flex-grow">@livewire('admin.select-event')</div>
    </div>
    <div class="mt-4 flex flex-row items-baseline gap-4">
        <div>
            <span class="block">Select Election Type</span>
        </div>
        <div class="flex flex-grow items-baseline justify-start gap-4">
            @foreach ($electionTypes as $electionType)
                <input
                    id="currentElectionType.{{ $electionType->id }}"
                    name="currentElectionType"
                    type="radio"
                    value="{{ $electionType->id }}"
                    wire:model="currentElectionTypeId"
                />
                <label for="currentElectionType.{{ $electionType->id }}">
                    {{ $electionType->name }}
                </label>
            @endforeach
        </div>
    </div>
    <div
        class="mt-4"
        x-data="{ currentElectionTypeId: @entangle('currentElectionTypeId') }"
        x-show="currentElectionTypeId === @js(\App\Models\ElectionType::TYPE_DSG)"
        x-transition.opacity
    >
        <label
            class="text-sm font-medium text-gray-700"
            for="department_id"
        >
            Department
        </label>
        <select
            class="mt-1 w-full rounded-md"
            id="department_id"
            name="department_id"
            wire:model.defer="form.department_id"
        >
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">
                    <span>{{ $department->name }}</span>
                </option>
            @endforeach
        </select>
        @error('department_id')
            <p class="text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>
    <div class="mt-4">
        <form
            wire:submit.prevent="createElection"
            method="post"
        >
            @csrf
            <div>
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="title"
                >
                    Title
                </label>
                <input
                    class="w-full rounded-md"
                    id="title"
                    name="title"
                    type="text"
                    wire:model.defer="form.title"
                />
                @error('title')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4">
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="description"
                >
                    Description (Optional)
                </label>
                <textarea
                    class="w-full rounded-md"
                    id="description"
                    name="description"
                    wire:model.defer="form.description"
                ></textarea>
            </div>
            <div class="mt-4">
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="start_at"
                >
                    Start At
                </label>
                <input
                    class="rounded-md"
                    id="start_at"
                    name="start_at"
                    type="datetime-local"
                    wire:model.defer="form.start_at"
                />

                @error('start_at')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4">
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="end_at"
                >
                    End At
                </label>
                <input
                    class="rounded-md"
                    id="end_at"
                    name="end_at"
                    type="datetime-local"
                    value="{{ old('end_at') }}"
                    wire:model.defer="form.end_at"
                />
                @error('end_at')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex justify-end">
                <x-button-primary
                    type="submit"
                    :disabled="$currentEvent === null"
                >
                    Create Election
                </x-button-primary>
            </div>
        </form>
    </div>
</div>
