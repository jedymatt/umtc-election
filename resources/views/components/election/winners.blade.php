<div class="overflow-x-auto border-x border-t">
    <table class="table-auto w-full">
        <thead class="border-b-2 border-b-gray-300">
        <tr class="bg-gray-100">
            <th class="text-left p-4 font-medium">
                Position
            </th>
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
        @foreach ($winners as $candidate)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4">
                    {{ $candidate->position->name }}
                </td>
                <td class="p-4">
                    {{ $candidate->user->name }}
                </td>
                <td class="p-4">
                    {{ $candidate->user->department?->name }}
                </td>
                <td class="p-4">
                    {{ $candidate->pivot->votes }}
                </td>
            </tr>
        @endforeach
        @if($winners->isEmpty())
            <tr class="border-b bg-gray-50">
                <td class="p-4" colspan="3">
                    <span class="text-gray-400 italic">No Winners</span>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
