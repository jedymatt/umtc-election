<div>
    <div class="relative min-h-[20rem] overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left text-sm text-gray-500">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                <tr>
                    <th
                        class="px-6 py-3"
                        scope="col"
                    >
                        Title
                    </th>
                    <th
                        class="px-6 py-3"
                        scope="col"
                    >
                        Status
                    </th>
                    <th
                        class="px-6 py-3"
                        scope="col"
                    >
                        Type
                    </th>
                    <th
                        class="px-6 py-3"
                        scope="col"
                    >
                        Department
                    </th>
                    <th
                        class="px-6 py-3"
                        scope="col"
                    >
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($elections as $election)
                    <tr
                        class="border-b bg-white align-text-top hover:bg-gray-50"
                        wire:loading.class='hidden'
                    >
                        <th
                            class="max-w-xs truncate whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                            scope="row"
                        >
                            {{ $election->title }}
                        </th>
                        <td class="px-6 py-4">
                            <span @class([
                                'uppercase text-xs py-0.5 px-1 rounded-full border',
                                'border-green-500 bg-green-100 text-green-800' => $election->isActive(),
                                'border-red-500 bg-red-100 text-red-800' => $election->isExpired(),
                                'border-orange-500 bg-orange-100 text-orange-800' => $election->isPending(),
                            ])>{{ $election->statusMessage() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $election->electionType->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $election->department?->name }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <div class="inline-flex flex-row items-center justify-center gap-2">
                                <a
                                    class="rounded-md bg-blue-600 px-2 py-1.5 font-medium text-white hover:bg-blue-500 hover:underline focus:bg-blue-800 focus:outline-none focus:ring focus:ring-blue-200"
                                    href="{{ route('admin.elections.show', $election) }}"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path
                                            fill-rule="evenodd"
                                            d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                                <a
                                    class="focus:bg-blue-8s00 rounded-md bg-blue-600 px-2 py-1.5 font-medium text-white hover:bg-blue-500 hover:underline focus:outline-none focus:ring focus:ring-blue-200"
                                    href="{{ route('admin.elections.live-result', $election) }}"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M1 2.75A.75.75 0 011.75 2h16.5a.75.75 0 010 1.5H18v8.75A2.75 2.75 0 0115.25 15h-1.072l.798 3.06a.75.75 0 01-1.452.38L13.41 18H6.59l-.114.44a.75.75 0 01-1.452-.38L5.823 15H4.75A2.75 2.75 0 012 12.25V3.5h-.25A.75.75 0 011 2.75zM7.373 15l-.391 1.5h6.037l-.392-1.5H7.373zm7.49-8.931a.75.75 0 01-.175 1.046 19.326 19.326 0 00-3.398 3.098.75.75 0 01-1.097.04L8.5 8.561l-2.22 2.22A.75.75 0 115.22 9.72l2.75-2.75a.75.75 0 011.06 0l1.664 1.663a20.786 20.786 0 013.122-2.74.75.75 0 011.046.176z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            class="h-64"
                            colspan="5"
                        >
                            <p class="text-center text-gray-500">No elections found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    <div class="mt-4">
        {{ $elections->links() }}
    </div>
</div>
