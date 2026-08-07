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
            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Total Clients
                </p>

                <div class="mt-3 flex items-end justify-between gap-4">
                    <p class="text-3xl font-bold text-stone-900 dark:text-stone-100">
                        24
                    </p>

                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400">
                        +3 this quarter
                    </p>
                </div>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Active Clients
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    18
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Active Projects
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    31
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Awaiting Response
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    4
                </p>
            </x-card>
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
                        24 client organizations
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
                                class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                Last Activity
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
                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                        AO
                                    </div>

                                    <div>
                                        <a
                                            href="#"
                                            class="font-semibold text-stone-900 hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            Acme Outdoor Supply
                                        </a>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            Retail
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm font-medium text-stone-800 dark:text-stone-200">
                                    Sarah Mitchell
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    Marketing Director
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                3 active
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="success">
                                    Active
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                12 minutes ago
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

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-stone-200 text-sm font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                        NF
                                    </div>

                                    <div>
                                        <a
                                            href="#"
                                            class="font-semibold text-stone-900 hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            Northstar Financial Group
                                        </a>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            Financial Services
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm font-medium text-stone-800 dark:text-stone-200">
                                    Olivia Bennett
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    Communications Manager
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                2 active
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="success">
                                    Active
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                Yesterday
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

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-amber-100 text-sm font-bold text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                        GL
                                    </div>

                                    <div>
                                        <a
                                            href="#"
                                            class="font-semibold text-stone-900 hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            GreenLeaf Co.
                                        </a>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            Sustainability
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm font-medium text-stone-800 dark:text-stone-200">
                                    Marcus Reed
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    Founder
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                1 active
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="warning">
                                    Awaiting response
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                4 days ago
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

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-stone-200 text-sm font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                        WI
                                    </div>

                                    <div>
                                        <a
                                            href="#"
                                            class="font-semibold text-stone-900 hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            Wave Industries
                                        </a>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            Technology
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm font-medium text-stone-800 dark:text-stone-200">
                                    Emily Carter
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    Product Director
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                4 active
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="success">
                                    Active
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                6 days ago
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

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm bg-stone-200 text-sm font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                        NS
                                    </div>

                                    <div>
                                        <a
                                            href="#"
                                            class="font-semibold text-stone-900 hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            Northwind Studio
                                        </a>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            Architecture
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm font-medium text-stone-800 dark:text-stone-200">
                                    Daniel Foster
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    Managing Partner
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                No active projects
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="neutral">
                                    Inactive
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                3 weeks ago
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
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-4 border-t border-stone-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                <p class="text-sm text-stone-500 dark:text-stone-400">
                    Showing
                    <span class="font-semibold text-stone-700 dark:text-stone-200">1</span>
                    to
                    <span class="font-semibold text-stone-700 dark:text-stone-200">5</span>
                    of
                    <span class="font-semibold text-stone-700 dark:text-stone-200">24</span>
                    clients
                </p>

                <div class="flex items-center gap-1">
                    <button
                        type="button"
                        disabled
                        class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-400 disabled:cursor-not-allowed disabled:opacity-50 dark:border-stone-700"
                    >
                        Previous
                    </button>

                    <button
                        type="button"
                        class="rounded-sm border border-indigo-600 bg-indigo-600 px-3 py-2 text-sm font-semibold text-white"
                    >
                        1
                    </button>

                    <button
                        type="button"
                        class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-600 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-900"
                    >
                        2
                    </button>

                    <button
                        type="button"
                        class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-600 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-900"
                    >
                        3
                    </button>

                    <button
                        type="button"
                        class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-600 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-900"
                    >
                        Next
                    </button>
                </div>
            </div>
        </x-card>
    </x-layouts.app.content>
</x-layouts.app>