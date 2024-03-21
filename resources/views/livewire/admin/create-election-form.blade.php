<div>
    <form wire:submit="submit">
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
                    wire:model="title"
            />
            @error('title')
            <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-4">
            <fieldset class="flex flex-row items-baseline gap-4">
                <div>
                    <span class="block">Select Election Type</span>
                </div>
                <div class="flex flex-grow justify-start gap-4">
                    @foreach ($electionTypes as $electionType)
                        <label class="flex items-center">
                            <input
                                    id="{{ $electionType->value }}"
                                    name="type"
                                    type="radio"
                                    value="{{ $electionType->value }}"
                                    wire:model.live="type"
                            />
                            <span class="ml-1"> {{ $electionType->label() }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
            @error('type')
            <p class="text-sm text-red-600">
                {{ $message }}
            </p>
            @enderror
        </div>
        <div
                class="mt-4"
                x-data="{ type: @entangle('type').live }"
                x-show="type === @js(\App\Enums\ElectionType::Dsg->value)"
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
                    wire:model="department_id"
            >
                <option value="" disabled selected>
                    Select Department
                </option>
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
                    wire:model="description"
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
                    wire:model="start_at"
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
                    wire:model="end_at"
            />
            @error('end_at')
            <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4 flex justify-end">
            <x-button-primary type="submit">
                Create Election
            </x-button-primary>
        </div>
    </form>
</div>
