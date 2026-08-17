<x-layouts.app>
    <x-layouts.app.content
        title="Tasks"
        description="Organize assignments, monitor deadlines, and keep project work moving."
    >
        <x-slot:actions>
            <x-button
                    href="{{ route('tasks.board') }}"
                    variant="success"
                >
                <x-heroicon-o-view-columns class="h-4 w-4" />

                Board View
            </x-button>
            @can('create', App\Models\Task::class)
                <x-button
                    href="{{ route('tasks.create') }}"
                >
                    <x-heroicon-o-plus class="h-4 w-4" />

                    New Task
                </x-button>
            @endcan
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
            <div class="border-b border-stone-200 px-6 py-5 dark:border-stone-800">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                            All Tasks
                        </h2>

                        @if( auth()->user()->isAgencyUser() )
                            <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                {{ $totalTaskCount }} tasks across {{ $totalProjectWithTasksCount }} projects
                            </p>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('tasks.index') }}">
                        <div class="flex flex-col gap-3 md:flex-row items-baseline">
                            <div class="relative">
                                <x-input
                                    name="search"
                                    type="search"
                                    placeholder="Search tasks..."
                                    icon="magnifying-glass"
                                    textSize="text-sm"
                                    value="{{ request('search') }}"
                                />
                            </div>

                            <x-select 
                                name="status" 
                                textSize="text-sm"
                                onchange="this.form.submit()"
                            >
                                <option value="">All statuses</option>
                                @foreach($statuses as $status)
                                    <option
                                        value="{{ $status->value }}"
                                        @selected(request('status') === $status->value)
                                    >
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </x-select>

                            <x-select 
                                name="priority" 
                                textSize="text-sm"
                                onchange="this.form.submit()"
                            >
                                <option value="">All priorities</option>
                                @foreach ($priorities as $priority)
                                    <option
                                        value="{{ $priority->value }}"
                                        @selected(request('priority') === $priority->value)
                                    >
                                        {{ $priority->label() }}
                                    </option>
                                @endforeach
                            </x-select>

                            <x-select 
                                name="assignee" 
                                textSize="text-sm"
                                onchange="this.form.submit()"
                            >
                                <option value="">All assignees</option>
                                @foreach ($assignees as $assignee)
                                    <option
                                        value="{{ $assignee->id }}"
                                        @selected(request('assignee') == $assignee->id)
                                    >
                                        {{ $assignee->name }}
                                    </option>
                                @endforeach
                            </x-select>

                            <x-button 
                                href="{{ route('tasks.index') }}"
                                type="button" 
                                variant="secondary">
                                Clear
                            </x-button>
                        </div>
                    </form>
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
                                        href="{{ route('tasks.show', $task) }}"
                                        class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        {{ $task->title }}
                                    </a>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-stone-700 dark:text-stone-300">
                                        {{ $task->project->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        {{ $task->project->client->name }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                       

                                        <span class="text-sm text-stone-700 dark:text-stone-300">
                                            {{ $task->assignedTo?->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <x-badge :variant="$task->status->badgeVariant()">
                                        {{ $task->status->label() }}
                                    </x-badge>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <x-badge :variant="$task->priority->badgeVariant()">
                                        {{ $task->priority->label() }}
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
                                        {{ $task->due_date->diffForHumans() }}
                                    </p>

                                    <p
                                        @class([
                                            'mt-1 text-xs text-stone-500 dark:text-stone-400',
                                        ])
                                    >
                                        {{ $task->due_date->format('M j, Y') }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div>
										<x-row-actions
											:viewRoute="route('tasks.show', $task)"
											:editRoute="auth()->user()->can('update', $task)
															? route('tasks.edit', $task)
															: null"
											:deleteRoute="auth()->user()->can('delete', $task)
															? route('tasks.destroy', $task)
															: null"
											:name="$task->title"
                                            :modalName="'task_' . $task->id"
                                            type="Task"
										/>
									</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-4 border-t border-stone-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                <p class="text-sm text-stone-500 dark:text-stone-400">
                    Showing
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $tasks->firstItem() ?? 0 }}</span>
                    to
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $tasks->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $tasks->total() }}</span>
                    tasks
                </p>

                <div class="flex items-center gap-1">
                    {{ $tasks->links() }}
                </div>
            </div>
        </x-card>
    </x-layouts.app.content>
</x-layouts.app>