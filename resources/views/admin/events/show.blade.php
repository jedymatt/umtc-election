<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">{{ $event->title }}</span>
                    <div>
                        DSG Elections: {{ $dsgElections->count()  }} / 7
                    </div>
                    <div>
                        CDSG Election: {{ $cdsgElections->count()  }} / 1
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">CDSG Elections</span>
                    <div class="flex justify-end mt-4">
                        <x-primary.button-link href="#">
                            Create CDSG Election
                        </x-primary.button-link>
                    </div>
                    <div class="mt-4">
                        <!-- component -->
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 font-medium">
                                        Title
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($cdsgElections as $election)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            {{ $election->title }}
                                        </td>
                                        <td class="p-4">
                                            {{ $election->status }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-b">
                                        <td class="p-4" colspan="3">
                                            <span class="flex justify-center text-gray-400">No records!</span>
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6"></div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span class="text-lg font-medium text-primary">DSG Elections</span>
                    <div class="flex justify-end mt-4">
                        <x-primary.button-link href="{{ route('admin.events.dsg-election.create', $event) }}">
                            Create DSG Election
                        </x-primary.button-link>
                    </div>
                    <div class="mt-4">
                        <!-- component -->
                        <div class="overflow-x-auto border-x border-t">
                            <table class="table-auto w-full">
                                <thead class="border-b">
                                <tr class="bg-gray-100">
                                    <th class="text-left p-4 font-medium">
                                        Title
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Status
                                    </th>
                                    <th class="text-left p-4 font-medium">
                                        Department
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($dsgElections as $election)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            {{ $election->title }}
                                        </td>
                                        <td class="p-4">
                                            {{ $election->status }}
                                        </td>
                                        <td class="p-4">
                                            {{ $election->department->name }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-b">
                                        <td class="p-4" colspan="3">
                                            <span
                                                class="flex justify-center text-gray-400">No records!</span>
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>