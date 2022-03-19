@foreach($positions as $position)
    <table>
        <thead>
        <tr>
            <th>{{ $position->name }}</th>
        </tr>
        <tr>
            <th>Candidates</th>
            <th>Votes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($candidates->filter(function ($candidate) use($position) { return $candidate->position_id == $position->id; }) as $candidate)
            <tr>
                <td>{{ $candidate->user->name }}</td>
                <td>{{ $candidate->votes_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
