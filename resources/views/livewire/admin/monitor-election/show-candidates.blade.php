<div>
    <div class="overflow-x-auto border-x border-t">
        <table class="table-auto w-full">
            <thead class="border-b-2 border-b-gray-300">
                <tr class="bg-gray-100">
                    <th class="text-left p-4 font-medium">
                        Name
                    </th>
                    <th class="text-left p-4 font-medium">
                        Department
                    </th>
                    <th class="text-left p-4 font-medium">
                        Votes
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $positionName => $positionCandidates)
                    <tr class="border-b border-l-8 border-l-primary ">
                        <td class="p-4" colspan="3">
                            <span class="font-medium text-primary">{{ $positionName }}</span>
                        </td>
                    </tr>
                    @forelse ($positionCandidates as $candidate)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">
                                {{ $candidate->user->name }}
                            </td>
                            <td class="p-4">
                                {{ $candidate->user->department->name }}
                            </td>
                            <td class="p-4">
                                {{ $candidate->votes_count }}
                            </td>
                        </tr>

                    @empty
                        <tr class="border-b bg-gray-50">
                            <td class="p-4" colspan="3">
                                <span class="text-gray-400 italic">No Candidates</span>
                            </td>
                        </tr>
                    @endforelse
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Echo.channel('{{ 'election.' . $election->id }}')
                .listen('vote-submitted', function() {
                    console.log('vote-submitted');
                });
            Livewire.on('election.{{ $election->id }},vote-submitted', function() {
                alert('vote submitted');
            })
        });
    </script>
</div>
