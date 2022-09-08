<div>
    <div class="flex flex-row justify-center items-baseline gap-4">
        <span class="block">Select Event</span>
        <div class="flex-grow">
            @livewire('admin.select-event')
        </div>
    </div>
    <div class="mt-4 flex flex-row items-baseline gap-4">
        <div>
            <span class="block">Select Election Type</span>
        </div>
        <div class="flex-grow flex justify-start items-baseline gap-4">
            @foreach ($electionTypes as $electionType)
                <input class="" type="radio" name="currentElectionType" wire:model="currentElectionTypeId"
                    wire:change="changeElectionType" id="currentElectionType.{{ $electionType->id }}"
                    value="{{ $electionType->id }}">
                <label class=""
                    for="currentElectionType.{{ $electionType->id }}">{{ $electionType->name }}</label>
            @endforeach

        </div>
    </div>
    <div x-data="{ showDepartmentsOption: @entangle('showDepartmentsOption') }" x-show="$wire.showDepartmentsOption"
        x-transition class="mt-4">
        <label class="text-sm font-medium text-gray-700" for="department_id">Department</label>
        <select name="department_id" id="department_id" wire:model.defer="form.department_id"
            class="mt-1 w-full rounded-md">
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">
                    <span>{{ $department->name }}</span>
                </option>
            @endforeach
        </select>
        @error('department_id')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div class="mt-4">
        <form wire:submit.prevent="createElection" method="post">
            @csrf
            <div>
                <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="w-full rounded-md"
                    wire:model.defer="form.title" />
                @error('title')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4">
                <label for="description" class="block font-medium text-sm text-gray-700">
                    Description (Optional)
                </label>
                <textarea name="description" id="description" class="w-full rounded-md" wire:model.defer="form.description"></textarea>
            </div>
            <div class="mt-4">
                <label for="start_at" class="block font-medium text-sm text-gray-700">Start
                    At</label>
                <input type="datetime-local" id="start_at" name="start_at" class="rounded-md"
                    wire:model.defer="form.start_at" />

                @error('start_at')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4">
                <label for="end_at" class="block font-medium text-sm text-gray-700">End At</label>
                <input type="datetime-local" id="end_at" name="end_at" class="rounded-md"
                    wire:model.defer="form.end_at" value="{{ old('end_at') }}" />
                @error('end_at')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex justify-end">
                <x-button-primary type="submit">Create Election</x-button-primary>
            </div>
        </form>
    </div>
</div>
