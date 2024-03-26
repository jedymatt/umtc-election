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
                        {{ $election->type->label() }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $election->department?->name }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-right">
                        <div class="inline-flex flex-row items-center justify-center gap-2">
                            @if($endedWithoutWinners->contains($election))
                                <a
                                    class="flex rounded-md bg-yellow-600 px-2 py-1.5 font-medium text-white hover:bg-yellow-500 hover:underline focus:bg-yellow-800 focus:outline-none focus:ring focus:ring-yellow-200"
                                    href="{{ route('admin.elections.result', $election) }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                              d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-2">Finalize Results</span>
                                </a>
                            @endif
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
                                    <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"/>
                                    <path
                                        fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </a>
                            <a
                                class="focus:bg-blue-8s00 rounded-md bg-blue-600 px-2 py-1.5 font-medium text-white hover:bg-blue-500 hover:underline focus:outline-none focus:ring focus:ring-blue-200"
                                href="{{ route('admin.elections.result', $election) }}"
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

                            <a
                                class="focus:bg-blue-8s00 rounded-md bg-blue-600 px-2 py-1.5 font-medium text-white hover:bg-blue-500 hover:underline focus:outline-none focus:ring focus:ring-blue-200"
                                href="{{ route('admin.elections.candidates', $election) }}"
                            >
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 9a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM1.615 16.428a1.224 1.224 0 01-.569-1.175 6.002 6.002 0 0111.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 017 18a9.953 9.953 0 01-5.385-1.572zM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 00-1.588-3.755 4.502 4.502 0 015.874 2.636.818.818 0 01-.36.98A7.465 7.465 0 0114.5 16z"
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
