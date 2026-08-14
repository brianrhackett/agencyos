<x-layouts.app>
    <x-layouts.app.content
        title="Clients"
        description="Manage client organizations, contacts, and active projects."
    >
        <x-slot:actions>
            <x-button
                href="{{ route('clients.create') }}"
            >
                <x-heroicon-o-plus class="h-4 w-4" />

                New Client
            </x-button>
        </x-slot:actions>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($summaryCards as $card)
                <x-card title="{{ $card['title'] }}">
                    <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                        {{ $card['value'] }}
                    </p>
                </x-card>
            @endforeach
        </div>

        <x-card
            :padding="false"
            class="mt-6"
        >
            <div class="flex flex-col gap-4 border-b border-stone-200 px-6 py-5 md:flex-row md:items-center md:justify-between dark:border-stone-800">
                <div>
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        All Clients
                    </h2>

                    <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                        {{ $totalClientsCount }} client organizations
                    </p>
                </div>

                <form method="GET" action="{{ route('clients.index') }}">
                    <div class="flex flex-col gap-3 sm:flex-row items-baseline">
                        <div class="relative">
                            <x-input
                                    name="search"
                                    type="search"
                                    placeholder="Search clients..."
                                    icon="magnifying-glass"
                                    textSize="text-sm"
                                    value="{{ request('search') }}"
                                />
                        </div>

                        <x-select
                            name="is_active" 
                            textSize="text-sm"
                            onchange="this.form.submit()"
                        >
                            <option value="">All statuses</option>
                            <option value="true" @selected(request('is_active') === 'true')>Active</option>
                            <option value="false" @selected(request('is_active') === 'false')>Inactive</option>
                        </x-select>

                        <x-button 
                            href="{{ route('clients.index') }}"
                            type="button" 
                            variant="secondary">
                            Clear
                        </x-button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-800">
                    <thead class="bg-stone-50 dark:bg-stone-900">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                Client
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                Primary Contact
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                Projects
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                Status
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
                        @foreach ($clients as $client)
                            <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a
                                            href="{{ route('clients.show', $client) }}"
                                            class="font-semibold text-stone-900 hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            {{ $client->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $primaryContact = $client->primaryContact->first();
                                    @endphp
                                    @if ($primaryContact)
                                        <p class="font-medium">
                                            {{ $primaryContact->name }}
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            {{ $primaryContact->pivot->job_title }}
                                        </p>
                                    @else
                                        <p class="font-medium">
                                            No Primary Contact.
                                        </p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                    {{ $client->active_projects_count }} active
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if ($client->is_active)
                                        <x-badge variant="success">
                                            Active
                                        </x-badge>
                                    @else
                                        <x-badge variant="neutral">
                                            Inactive
                                        </x-badge>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <x-row-actions
                                        :viewRoute="route('clients.show', $client)"
                                        :editRoute="route('clients.edit', $client)"
                                        :deleteRoute="route('clients.destroy', $client)"
                                        :name="$client->name"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-4 border-t border-stone-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                <p class="text-sm text-stone-500 dark:text-stone-400">
                    Showing
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $clients->firstItem() }}</span>
                    to
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $clients->lastItem() }}</span>
                    of
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $clients->total() }}</span>
                    clients
                </p>

                <div class="flex items-center gap-1">
                    {{ $clients->links() }}
                </div>
            </div>
        </x-card>
    </x-layouts.app.content>
</x-layouts.app>