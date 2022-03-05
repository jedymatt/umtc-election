<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="w-full sm:w-1/3">
        <x-input type="text" wire:model="search" wire:keyup.debounce.300ms="searchUsers"
                 placeholder="Search students by name"
                 class="w-full"/>
        <div class="block">
            @foreach ($users as $user)
                <div class="w-full p-1 hover:cursor-pointer hover:bg-gray-700">
                   <div class="bg-gray-100" wire:click="addUserToCandidates({{ $user }})">
                       {{ $user->name }}
                   </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Remove</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($candidates as $candidate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full"
                                                     src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                                     alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $candidate->user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="ml-1 text-red-600 hover:text-indigo-900"
                                            wire:click="removeCandidate( {{ $candidate }})"
                                        >Remove</button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
