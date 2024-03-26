<div class="border-b border-gray-200 bg-white p-6">
    <div>
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select id="tabs" name="tabs"
                    class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="window.location.href = this.value"
            >
                <option value="{{ route('admin.elections.show', $election) }}"
                    @selected(request()->routeIs('admin.elections.show'))
                >
                    Information
                </option>
                <option value="{{ route('admin.elections.result', $election) }}"
                    @selected(request()->routeIs('admin.elections.result'))
                >
                    Results
                </option>
                <option value="{{ route('admin.elections.candidates', $election) }}"
                    @selected(request()->routeIs('admin.elections.candidates'))
                >
                    Manage Candidates
                </option>
            </select>
        </div>
        <div class="hidden sm:block">
            <nav class="flex space-x-4" aria-label="Tabs">
                <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
                <a href="{{ route('admin.elections.show', $election) }}"
                   class="{{ request()->routeIs('admin.elections.show') ? 'bg-indigo-100 text-indigo-700 rounded-md px-3 py-2 text-sm font-medium' : 'text-gray-500 hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium' }}"
                    {{ request()->routeIs('admin.elections.show') ? 'aria-current="page"' : '' }}
                >
                    Information
                </a>
                <a href="{{ route('admin.elections.result', $election) }}"
                   class="{{ request()->routeIs('admin.elections.result') ? 'bg-indigo-100 text-indigo-700 rounded-md px-3 py-2 text-sm font-medium' : 'text-gray-500 hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium' }}"
                    {{ request()->routeIs('admin.elections.result') ? 'aria-current="page"' : '' }}
                >
                    Results
                </a>
                <a href="{{ route('admin.elections.candidates', $election) }}"
                   class="{{ request()->routeIs('admin.elections.candidates') ? 'bg-indigo-100 text-indigo-700 rounded-md px-3 py-2 text-sm font-medium' : 'text-gray-500 hover:text-gray-700 rounded-md px-3 py-2 text-sm font-medium' }}"
                    {{ request()->routeIs('admin.elections.candidates') ? 'aria-current="page"' : '' }}
                >
                    Manage Candidates
                </a>
            </nav>
        </div>
    </div>
</div>
