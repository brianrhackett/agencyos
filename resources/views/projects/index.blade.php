<x-layouts.app>
    <x-layouts.app.content
        title="Projects"
        description="Track client work, milestones, deadlines, and project health."
    >
        <x-slot:actions>
            <x-button>
                <x-heroicon-o-plus class="h-4 w-4" />

                New Project
            </x-button>
        </x-slot:actions>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Active Projects
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    12
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Due This Month
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    5
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Needs Attention
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    3
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Completed This Quarter
                </p>

                <div class="mt-3 flex items-end justify-between gap-4">
                    <p class="text-3xl font-bold text-stone-900 dark:text-stone-100">
                        8
                    </p>

                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400">
                        +2 from last quarter
                    </p>
                </div>
            </x-card>
        </div>

        <x-card
            :padding="false"
            class="mt-6"
        >
            <div class="flex flex-col gap-4 border-b border-stone-200 px-6 py-5 xl:flex-row xl:items-center xl:justify-between dark:border-stone-800">
                <div>
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        All Projects
                    </h2>

                    <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                        18 projects across 11 clients
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative">
                        <x-heroicon-o-magnifying-glass
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                        />

                        <input
                            type="search"
                            placeholder="Search projects..."
                            class="w-full rounded-sm border border-stone-300 bg-white py-2 pl-9 pr-3 text-sm text-stone-900 outline-none transition-colors placeholder:text-stone-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:w-64 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                        >
                    </div>

                    <select
                        class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    >
                        <option>All statuses</option>
                        <option>Planning</option>
                        <option>Active</option>
                        <option>On hold</option>
                        <option>Completed</option>
                    </select>

                    <select
                        class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    >
                        <option>All clients</option>
                        <option>Acme Outdoor Supply</option>
                        <option>Northstar Financial Group</option>
                        <option>GreenLeaf Co.</option>
                        <option>Wave Industries</option>
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
                                Project
                            </th>

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
                                Progress
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
                                Due Date
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400"
                            >
                                Project Manager
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
                            <td class="px-6 py-4">
                                <div>
                                    <a
                                        href="#"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        E-commerce Website Redesign
                                    </a>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        3 milestones · 14 open tasks
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-700 dark:text-stone-300">
                                Acme Outdoor Supply
                            </td>

                            <td class="min-w-44 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                                        <div class="h-full w-[68%] bg-indigo-600"></div>
                                    </div>

                                    <span class="w-10 text-right text-xs font-semibold text-stone-600 dark:text-stone-300">
                                        68%
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="success">
                                    Active
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm text-stone-700 dark:text-stone-300">
                                    Dec 12, 2026
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    128 days remaining
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                        MR
                                    </div>

                                    <span class="text-sm text-stone-700 dark:text-stone-300">
                                        Maya Rodriguez
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button
                                    type="button"
                                    class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                    aria-label="Project actions"
                                >
                                    <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                </button>
                            </td>
                        </tr>

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="px-6 py-4">
                                <div>
                                    <a
                                        href="#"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        Digital Brand Refresh
                                    </a>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        2 milestones · 8 open tasks
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-700 dark:text-stone-300">
                                Northstar Financial Group
                            </td>

                            <td class="min-w-44 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                                        <div class="h-full w-[24%] bg-indigo-600"></div>
                                    </div>

                                    <span class="w-10 text-right text-xs font-semibold text-stone-600 dark:text-stone-300">
                                        24%
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="neutral">
                                    Planning
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm text-stone-700 dark:text-stone-300">
                                    Nov 8, 2026
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    94 days remaining
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-stone-200 text-xs font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                        BH
                                    </div>

                                    <span class="text-sm text-stone-700 dark:text-stone-300">
                                        Brian Hackett
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button
                                    type="button"
                                    class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                    aria-label="Project actions"
                                >
                                    <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                </button>
                            </td>
                        </tr>

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="px-6 py-4">
                                <div>
                                    <a
                                        href="#"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        Marketing Site Refresh
                                    </a>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        4 milestones · 6 open tasks
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-700 dark:text-stone-300">
                                GreenLeaf Co.
                            </td>

                            <td class="min-w-44 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                                        <div class="h-full w-[52%] bg-amber-500"></div>
                                    </div>

                                    <span class="w-10 text-right text-xs font-semibold text-stone-600 dark:text-stone-300">
                                        52%
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="warning">
                                    On hold
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm font-medium text-red-600 dark:text-red-400">
                                    Aug 3, 2026
                                </p>

                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    3 days overdue
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-stone-200 text-xs font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                        MR
                                    </div>

                                    <span class="text-sm text-stone-700 dark:text-stone-300">
                                        Maya Rodriguez
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button
                                    type="button"
                                    class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                    aria-label="Project actions"
                                >
                                    <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                </button>
                            </td>
                        </tr>

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="px-6 py-4">
                                <div>
                                    <a
                                        href="#"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        Customer Portal Build
                                    </a>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        5 milestones · 21 open tasks
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-700 dark:text-stone-300">
                                Wave Industries
                            </td>

                            <td class="min-w-44 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                                        <div class="h-full w-[81%] bg-indigo-600"></div>
                                    </div>

                                    <span class="w-10 text-right text-xs font-semibold text-stone-600 dark:text-stone-300">
                                        81%
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="success">
                                    Active
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm text-stone-700 dark:text-stone-300">
                                    Sep 22, 2026
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    47 days remaining
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                        BH
                                    </div>

                                    <span class="text-sm text-stone-700 dark:text-stone-300">
                                        Brian Hackett
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button
                                    type="button"
                                    class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                    aria-label="Project actions"
                                >
                                    <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                </button>
                            </td>
                        </tr>

                        <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                            <td class="px-6 py-4">
                                <div>
                                    <a
                                        href="#"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        SEO Audit and Content Strategy
                                    </a>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        3 milestones · 0 open tasks
                                    </p>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-700 dark:text-stone-300">
                                Northwind Studio
                            </td>

                            <td class="min-w-44 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-1.5 flex-1 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                                        <div class="h-full w-full bg-emerald-600"></div>
                                    </div>

                                    <span class="w-10 text-right text-xs font-semibold text-stone-600 dark:text-stone-300">
                                        100%
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <x-badge variant="primary">
                                    Completed
                                </x-badge>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <p class="text-sm text-stone-700 dark:text-stone-300">
                                    Jul 28, 2026
                                </p>

                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                    Completed
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-stone-200 text-xs font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                        EB
                                    </div>

                                    <span class="text-sm text-stone-700 dark:text-stone-300">
                                        Ethan Brooks
                                    </span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <button
                                    type="button"
                                    class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                    aria-label="Project actions"
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
                    <span class="font-semibold text-stone-700 dark:text-stone-200">18</span>
                    projects
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