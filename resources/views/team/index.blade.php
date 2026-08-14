<x-layouts.app>
    <x-layouts.app.content
        title="Team"
        description="Manage team members, roles, assignments, and workload."
    >
        <x-slot:actions>
            @can('create', App\Models\User::class)
                <x-button
                    href="{{ route('team.create') }}"
                >
                    <x-heroicon-o-user-plus class="h-4 w-4" />

                    Invite Member
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
            <div class="flex flex-col gap-4 border-b border-stone-200 px-6 py-5 lg:flex-row lg:items-center lg:justify-between dark:border-stone-800">
                <div>
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        Team Directory
                    </h2>

                    <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                        {{ $teamMembersCount }} team members
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative">
                        <x-heroicon-o-magnifying-glass
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                        />

                        <input
                            type="search"
                            placeholder="Search team members..."
                            class="w-full rounded-sm border border-stone-300 bg-white py-2 pl-9 pr-3 text-sm text-stone-900 outline-none transition-colors placeholder:text-stone-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:w-64 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                        >
                    </div>

                    <select
                        class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    >
                        <option>All roles</option>
                        <option>Administrator</option>
                        <option>Project Manager</option>
                        <option>Team Member</option>
                    </select>

                    <select
                        class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                    >
                        <option>All statuses</option>
                        <option>Active</option>
                        <option>Invited</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>

            <ul class="divide-y divide-stone-200 dark:divide-stone-800">
                @foreach ($teamMembers as $member)
                    <li class="px-6 py-5 transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-center">
                            <div class="flex min-w-0 flex-1 items-center gap-4">

                                <div class="min-w-0">
                                    <a
                                        href="{{ route('team.show', $member['user']) }}"
                                        class="truncate font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        {{ $member['name'] }}
                                    </a>

                                    <p class="mt-1 truncate text-sm text-stone-500 dark:text-stone-400">
                                        {{ $member['email'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid flex-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-stone-500">
                                        Position
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-stone-700 dark:text-stone-300">
                                        {{ $member['position'] }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-stone-500">
                                        Role
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-stone-700 dark:text-stone-300">
                                        {{ $member['role'] }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-stone-500">
                                        Workload
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-stone-700 dark:text-stone-300">
                                        {{ $member['projects'] }} projects &sdot; {{ $member['open_tasks'] }} tasks
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-stone-500">
                                        Due Today
                                    </p>

                                    <p
                                        @class([
                                            'mt-1 text-sm font-medium',
                                            'text-stone-700 dark:text-stone-300' => $member['due_today'] === 0,
                                            'text-amber-600 dark:text-amber-400' => $member['due_today'] > 0,
                                        ])
                                    >
                                        {{ $member['due_today'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex shrink-0 items-center justify-between gap-4 xl:justify-end">
                                <div>
                                    <x-row-actions
                                        :viewRoute="route('team.show', $member['user'])"
                                        :editRoute="auth()->user()->can('update', $member['user'])
															? route('team.edit', $member['user'])
															: null"
                                        :deleteRoute="auth()->user()->can('delete', $member['user'])
															? route('team.destroy', $member['user'])
															: null"
                                        :name="$member['name']"
                                    />
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="flex flex-col gap-4 border-t border-stone-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                <p class="text-sm text-stone-500 dark:text-stone-400">
                    Showing
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $teamMembers->firstItem() ?? 0 }}</span>
                    to
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $teamMembers->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $teamMembers->total() }}</span>
                    team members
                </p>

                <div class="flex items-center gap-1">
                    {{ $teamMembers->links() }}
                </div>
            </div>
        </x-card>
    </x-layouts.app.content>
</x-layouts.app>
