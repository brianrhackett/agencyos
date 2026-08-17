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
                <form method="GET" action="{{ route('team.index') }}">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative">
                            <x-input
                                name="search"
                                type="search"
                                placeholder="Search team members..."
                                icon="magnifying-glass"
                                textSize="text-sm"
                                value="{{ request('search') }}"
                            />
                        </div>
                        <x-button 
                            href="{{ route('team.index') }}"
                            type="button" 
                            variant="secondary">
                            Clear
                        </x-button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 dark:divide-stone-800 relative z-20">
                    <thead class="bg-stone-50 dark:bg-stone-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                User
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Position
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Role
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Workload
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                Due Today
                            </th>

                            <th class="px-6 py-3 text-right">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
                        @foreach ($teamMembers as $member)
                            <tr class="px-6 py-5 transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                               <td class="px-6 py-4">
                                    <a
                                        href="{{ route('team.show', $member['user']) }}"
                                        class="truncate font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        {{ $member['name'] }}
                                    </a>

                                    <p class="mt-1 truncate text-sm text-stone-500 dark:text-stone-400">
                                        {{ $member['email'] }}
                                    </p>
                                </td>
                                        
                                <td class="px-6 py-4">                                    
                                    {{ $member['position'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $member['role'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $member['projects'] }} projects &sdot; {{ $member['open_tasks'] }} tasks
                                </td>
                                <td class="px-6 py-4">
                                    <p
                                        @class([
                                            'mt-1 text-sm font-medium',
                                            'text-stone-700 dark:text-stone-300' => $member['due_today'] === 0,
                                            'text-amber-600 dark:text-amber-400' => $member['due_today'] > 0,
                                        ])
                                    >
                                        {{ $member['due_today'] }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <x-row-actions
                                        :viewRoute="route('team.show', $member['user'])"
                                        :editRoute="auth()->user()->can('update', $member['user'])
                                                            ? route('team.edit', $member['user'])
                                                            : null"
                                        :deleteRoute="auth()->user()->can('delete', $member['user'])
                                                            ? route('team.destroy', $member['user'])
                                                            : null"
                                        :name="$member['name']"
                                        type="Team Member"
                                        :modalName="'member_' . $member['user']->id"
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
