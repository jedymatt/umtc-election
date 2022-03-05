<div>
    <x-label :value="$position->name"/>
    <x-input wire:model="search" type="text" wire:keydown.debounce="searchUsers"/>
    {{--            Result section--}}
    <div>
        @isset($users)
                @foreach($users as $user)
                    <div>
                        {{ $user->name }}
                    </div>
                @endforeach
        @endisset
    </div>
    {{--                Added candidates--}}
    <div>
        {{--                    candidates added--}}
    </div>
</div>
