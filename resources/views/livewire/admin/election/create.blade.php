<div>
    <form action="{{ route('admin.elections.store') }}" method="post">
        @csrf
        <div>
            <div>
                <x-label for="title" value="Title"/>
                <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                         :value="old('title')"
                         required autofocus/>
            </div>
            <div class="mt-4">
                <x-label for="description" value="Description (Optional)"/>
                <x-textarea id="description" name="description" rows="3"
                            class="block mt-1 w-full">{{ old('description') }}</x-textarea>
            </div>
            <div class="mt-4">
                <x-label for="start_at" value="Start At"/>
                <x-input type="datetime-local" id="start_at" name="start_at"/>
            </div>
            <div class="mt-4">
                <x-label for="end_at" value="End At"/>
                <x-input type="datetime-local" id="end_at" name="end_at"/>
            </div>
            <div>
                <div class="mt-4">
                    <x-label for="election_type_id" value="Election Type"/>
                    <select wire:model="electionTypeId" id="election_type_id" name="election_type_id" class="rounded-md"
                    wire:change="onChangeElectionType">
                        @foreach($electionTypes as $electionType)
                            <option value="{{$electionType->id }}">
                                {{ $electionType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if ($showDepartments)
                    <div class="mt-4">
                        <x-label for="department_id" value="Department"/>
                        <select name="department_id" id="department_id">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <x-button>
                Create Election
            </x-button>
        </div>
    </form>
</div>
