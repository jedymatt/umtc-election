<div>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
    <div>
        {{ $position->name }}

        <div>
            @foreach($candidates as $candidate)
                <div>
                    <input type="radio" id="{{ $position->id }}.candidate.{{ $candidate->id }}" name="{{$position->id}}.candidate_id" value="{{$candidate->id}}">
                    <label for="{{ $position->id }}.candidate.{{ $candidate->id }}">{{ $candidate->user->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
