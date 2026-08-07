<x-layouts.app>
    @php
        $tasks = [
            [
                'title' => 'Finalize homepage wireframes',
                'project' => 'E-commerce Website Redesign',
                'client' => 'Acme Outdoor Supply',
                'assignee' => 'Ethan Brooks',
                'initials' => 'EB',
                'status' => 'In review',
                'status_variant' => 'primary',
                'priority' => 'High',
                'priority_variant' => 'danger',
                'due' => 'Today',
                'due_detail' => 'Aug 6, 2026',
                'overdue' => false,
            ],
            [
                'title' => 'Collect product photography',
                'project' => 'E-commerce Website Redesign',
                'client' => 'Acme Outdoor Supply',
                'assignee' => 'Maya Rodriguez',
                'initials' => 'MR',
                'status' => 'Blocked',
                'status_variant' => 'warning',
                'priority' => 'Normal',
                'priority_variant' => 'neutral',
                'due' => '2 days overdue',
                'due_detail' => 'Aug 4, 2026',
                'overdue' => true,
            ],
            [
                'title' => 'Build authenticated dashboard shell',
                'project' => 'Customer Portal Build',
                'client' => 'Wave Industries',
                'assignee' => 'Brian Hackett',
                'initials' => 'BH',
                'status' => 'In progress',
                'status_variant' => 'success',
                'priority' => 'High',
                'priority_variant' => 'danger',
                'due' => 'Tomorrow',
                'due_detail' => 'Aug 7, 2026',
                'overdue' => false,
            ],
            [
                'title' => 'Review updated brand guidelines',
                'project' => 'Digital Brand Refresh',
                'client' => 'Northstar Financial Group',
                'assignee' => 'Maya Rodriguez',
                'initials' => 'MR',
                'status' => 'To do',
                'status_variant' => 'neutral',
                'priority' => 'Normal',
                'priority_variant' => 'neutral',
                'due' => 'In 3 days',
                'due_detail' => 'Aug 9, 2026',
                'overdue' => false,
            ],
            [
                'title' => 'Configure staging environment',
                'project' => 'Marketing Site Refresh',
                'client' => 'GreenLeaf Co.',
                'assignee' => 'Brian Hackett',
                'initials' => 'BH',
                'status' => 'Completed',
                'status_variant' => 'primary',
                'priority' => 'Low',
                'priority_variant' => 'neutral',
                'due' => 'Completed',
                'due_detail' => 'Aug 2, 2026',
                'overdue' => false,
            ],
        ];
    @endphp

    <x-layouts.app.content
        title="Tasks"
        description="Organize assignments, monitor deadlines, and keep project work moving."
    >
        <x-slot:actions>
            <x-button>
                <x-heroicon-o-plus class="h-4 w-4" />

                New Task
            </x-button>
        </x-slot:actions>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Open Tasks
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    47
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Due Today
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    7
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Overdue
                </p>

                <p class="mt-3 text-3xl font-bold text-red-600 dark:text-red-400">
                    4
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Completed This Week
                </p>

                <div class="mt-3 flex items-end justify-between gap-4">
                    <p class="text-3xl font-bold text-stone-900 dark:text-stone-100">
                        19
                    </p>

                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400">
                        +6 from last week
                    </p>
                </div>
            </x-card>
        </div>

        <x-card
            :padding="false"
            class="mt-6"
        >
            <div class="border-b border-stone-200 px-6 py-5 dark:border-stone-800">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                            All Tasks
                        </h2>

                        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                            62 tasks across 18 projects
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 md:flex-row">
                        <div class="relative">
                            <x-heroicon-o-magnifying-glass
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                            />

                            <input
                                type="search"
                                placeholder="Search tasks..."
                                class="w-full rounded-sm border border-stone-300 bg-white py-2 pl-9 pr-3 text-sm text-stone-900 outline-none transition-colors placeholder:text-stone-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 md:w-64 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                            >
                        </div>

                        <select class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200">
                            <option>All statuses</option>
                            <option>To do</option>
                            <option>In progress</option>
                            <option>In review</option>
                            <option>Blocked</option>
                            <option>Completed</option>
                        </select>

                        <select class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200">
                            <option>All priorities</option>
                            <option>Urgent</option>
                            <option>High</option>
                            <option>Normal</option>
                            <option>Low</option>
                        </select>

                        <select class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200">
                            <option>All assignees</option>
                            <option>Brian Hackett</option>
                            <option>Maya Rodriguez</option>
                            <option>Ethan Brooks</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-800">
                    <thead class="bg-stone-50 dark:bg-stone-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Task
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Project
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Assignee
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Status
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Priority
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Due Date
                            </th>

                            <th class="px-6 py-3 text-right">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
                        @foreach ($tasks as $task)
                            <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                                <td class="px-6 py-4">
                                    <a
                                        href="#"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        {{ $task['title'] }}
                                    </a>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-stone-700 dark:text-stone-300">
                                        {{ $task['project'] }}
                                    </p>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        {{ $task['client'] }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-stone-200 text-xs font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                            {{ $task['initials'] }}
                                        </div>

                                        <span class="text-sm text-stone-700 dark:text-stone-300">
                                            {{ $task['assignee'] }}
                                        </span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <x-badge :variant="$task['status_variant']">
                                        {{ $task['status'] }}
                                    </x-badge>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <x-badge :variant="$task['priority_variant']">
                                        {{ $task['priority'] }}
                                    </x-badge>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <p
                                        @class([
                                            'text-sm font-medium',
                                            'text-red-600 dark:text-red-400' => $task['overdue'],
                                            'text-stone-700 dark:text-stone-300' => ! $task['overdue'],
                                        ])
                                    >
                                        {{ $task['due'] }}
                                    </p>

                                    <p
                                        @class([
                                            'mt-1 text-xs',
                                            'text-red-600 dark:text-red-400' => $task['overdue'],
                                            'text-stone-500 dark:text-stone-400' => ! $task['overdue'],
                                        ])
                                    >
                                        {{ $task['due_detail'] }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <button
                                        type="button"
                                        class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                        aria-label="Task actions"
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
                    <span class="font-semibold text-stone-700 dark:text-stone-200">1</span>
                    to
                    <span class="font-semibold text-stone-700 dark:text-stone-200">5</span>
                    of
                    <span class="font-semibold text-stone-700 dark:text-stone-200">62</span>
                    tasks
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