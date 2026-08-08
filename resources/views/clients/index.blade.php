<x-layouts.app>
    <x-layouts.app.content
        title="Clients"
        description="Manage client organizations, contacts, and active projects."
    >
        <x-slot:actions>
            <x-button>
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

                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative">
                        <x-heroicon-o-magnifying-glass
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                        />

                        <input
                            type="search"
                            placeholder="Search clients..."
                            class="w-full rounded-sm border border-stone-300 bg-white py-2 pl-9 pr-3 text-sm text-stone-900 outline-none transition-colors placeholder:text-stone-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:w-64 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                        >
                    </div>

                    <select
                        class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    >
                        <option>All statuses</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
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
                                            href="#"
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
                                    <button
                                        type="button"
                                        class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                        aria-label="Client actions"
                                    >
                                        <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                    </button>
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