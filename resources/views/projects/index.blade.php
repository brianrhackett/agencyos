<x-layouts.app>
    <x-layouts.app.content
        title="Projects"
        description="Track client work, milestones, deadlines, and project health."
    >
        @can('create', App\Models\Project::class)
            <x-slot:actions>
                <x-button
                    href="{{ route('projects.create') }}"
                >
                    <x-heroicon-o-plus class="h-4 w-4" />

                    New Project
                </x-button>
            </x-slot:actions>
        @endcan

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
            <div class="flex flex-col gap-4 border-b border-stone-200 px-6 py-5 xl:flex-row xl:items-center xl:justify-between dark:border-stone-800">
                <div>
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        All Projects
                    </h2>
                    @if( auth()->user()->isAgencyUser() )
                        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                            {{ $activeProjectCount }} projects across {{ $clientsWithActiveProjects }} clients
                        </p>
                    @endif
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
                        @foreach ($projects as $project)
                            <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                                <td class="px-6 py-4">
                                    <div>
                                        <a
                                            href="{{ route('projects.show', $project) }}"
                                            class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                        >
                                            {{ $project->name }}
                                        </a>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            {{ $project->milestones_count }} milestones &sdot; {{ $project->open_tasks_count }} open tasks
                                        </p>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-700 dark:text-stone-300">
                                    {{ $project->client->name }}
                                </td>

                                @php
                                    $progress = $project->tasks_count > 0
                                        ? round(($project->completed_tasks_count / $project->tasks_count) * 100)
                                        : 0;
                                @endphp

                                <td class="min-w-44 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-1.5 flex-1 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                                            <div 
                                                class="h-full bg-indigo-600"
                                                style="width:{{ $progress }}%;">
                                            </div>
                                        </div>

                                        <span class="w-10 text-right text-xs font-semibold text-stone-600 dark:text-stone-300">
                                            {{ $progress }}%
                                        </span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <x-badge :variant="$project->status->badgeVariant()">
                                        {{ $project->status->label() }}
                                    </x-badge>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <p class="text-sm text-stone-700 dark:text-stone-300">
                                        {{ $project->due_date->format('M j, Y') }}
                                    </p>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        @if ($project->status === 'completed')
                                            Completed
                                        @elseif ($project->due_date->isPast())
                                            <span class="text-red-600">{{ $project->due_date->diffForHumans() }}</span>
                                        @else
                                            {{ $project->due_date->diffForHumans() }}
                                        @endif
                                    </p>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm text-stone-700 dark:text-stone-300">
                                            {{ $project->projectManager?->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <x-row-actions
                                        :viewRoute="route('projects.show', $project)"
                                        :editRoute="auth()->user()->can('update', $project)
															? route('projects.edit', $project)
															: null"
                                        :deleteRoute="auth()->user()->can('delete', $project)
															? route('projects.destroy', $project)
															: null"
                                        :name="$project->name"
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
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $projects->firstItem() ?? 0 }}</span>
                    to
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $projects->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $projects->total() }}</span>
                    projects
                </p>

                <div class="flex items-center gap-1">
                    {{ $projects->links() }}
                </div>
            </div>
        </x-card>
    </x-layouts.app.content>
</x-layouts.app>