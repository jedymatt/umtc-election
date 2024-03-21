<div>
    <form wire:submit="updateProfileInformation">
        @method('put')
        @csrf
        <div>
            <x-label value="Full Name"/>
            <x-input
                class="mt-1 w-full"
                id="name"
                name="name"
                type="text"
                wire:model="state.name"
                required
            />
            @error('state.name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-4">
            <x-label value="Email Address"/>
            <x-input
                class="mt-1 w-full select-none text-gray-600 hover:cursor-not-allowed"
                type="email"
                wire:model="state.email"
                disabled
            />
        </div>
        <div class="mt-4">
            <x-label value="Department"/>
            <select
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:w-1/2"
                wire:model="state.department_id"
            >
                <option
                    value=""
                    selected
                    disabled
                >
                    -- Select department --
                </option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('state.department_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mt-4 flex items-center justify-end">
            <x-button wire:loading.attr="disabled" type="submit">Save</x-button>
        </div>
    </form>
</div>
