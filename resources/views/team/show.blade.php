<x-layouts.app>
    <x-layouts.app.content
        title="{{ $user->name }}"
        description="{{ $user->position ?? 'Agency Team Member' }}"
    >
        <div class="space-y-6">
            <div class="flex flex-wrap items-center justify-end gap-3">
                @can('update', $user)
                    <form
                        method="POST"
                        action="{{ route('team.password-reset', $user) }}"
                    >
                        @csrf

                        <x-button type="submit" variant="primary" icon="link">
                            Send Password Reset Link
                        </x-button>
                    </form>
       
                    <x-button
                        href="{{ route('team.edit', $user) }}"
                        variant="secondary"
                        icon="pencil"
                    >
                        Edit Team Member
                    </x-button>
                @endcan

                @can('delete', $user)
                    <x-button
                        type="button"
                        variant="danger"
                        x-data
                        x-on:click="$dispatch('open-modal', 'confirm-delete')"
                        icon="trash"
                    >
                        Delete Team Member
                    </x-button>
                    <x-delete-modal
                        type="user"
                        name="User"
                        :action="route('team.destroy', $user)"
                    />
                @endif
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <x-card>
                        <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                            Team Member Details
                        </h2>

                        <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                                    Name
                                </dt>

                                <dd class="mt-1 text-sm text-stone-900 dark:text-stone-100">
                                    {{ $user->name }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                                    Email
                                </dt>

                                <dd class="mt-1 text-sm text-stone-900 dark:text-stone-100">
                                    {{ $user->email }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                                    Job Title
                                </dt>

                                <dd class="mt-1 text-sm text-stone-900 dark:text-stone-100">
                                    {{ $jobTitle }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                                    Role
                                </dt>

                                <dd class="mt-1 text-sm text-stone-900 dark:text-stone-100">
                                    {{ $role }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-stone-500">
                                    Joined
                                </dt>

                                <dd class="mt-1 text-sm text-stone-900 dark:text-stone-100">
                                    {{ $user->created_at->format('M j, Y') }}
                                </dd>
                            </div>
                        </dl>
                    </x-card>
                </div>

                <x-card>
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        Task Summary
                    </h2>

                    <div class="mt-6 space-y-4">
                        <div>
                            <p class="text-2xl font-bold text-stone-900 dark:text-stone-100">
                                {{ $user->assignedTasks->where('status', '!=', 'completed')->count() }}
                            </p>

                            <p class="text-sm text-stone-500">
                                Open tasks
                            </p>
                        </div>

                        <div>
                            <p class="text-2xl font-bold text-stone-900 dark:text-stone-100">
                                {{ $user->assignedTasks->where('status', 'completed')->count() }}
                            </p>

                            <p class="text-sm text-stone-500">
                                Completed tasks
                            </p>
                        </div>
                    </div>
                </x-card>
            </div>

            @if ($canSeeAssignedTasks)
                <x-card>
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        Assigned Tasks
                    </h2>

                    @if ($user->assignedTasks->isEmpty())
                        <p class="mt-4 text-sm text-stone-500">
                            No tasks assigned.
                        </p>
                    @else
                        <div class="mt-4 divide-y divide-stone-200 dark:divide-stone-800">
                            @foreach ($user->assignedTasks as $task)
                                <a
                                    href="{{ route('tasks.show', $task) }}"
                                    class="flex items-center justify-between gap-4 py-4 hover:text-indigo-600 dark:hover:text-indigo-400"
                                >
                                    <div>
                                        <p class="text-sm font-semibold">
                                            {{ $task->title }}
                                        </p>

                                        <p class="mt-1 text-xs text-stone-500">
                                            {{ $task->project?->name ?? 'No project' }}
                                        </p>
                                    </div>

                                    <span class="text-xs text-stone-500">
                                        {{ $task->due_date?->format('M j, Y') ?? 'No due date' }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </x-card>
            @endif
        </div>
    </x-layouts.app.content>
</x-layouts.app>