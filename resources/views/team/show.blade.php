<x-layouts.app>
    <x-layouts.app.content
        title="{{ $user->name }}"
        description="{{ $user->position ?? 'Agency Team Member' }}"
    >
        <div class="space-y-6">
            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('team.edit', $user) }}"
                    class="inline-flex items-center rounded-sm border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-800"
                >
                    Edit Team Member
                </a>

                @if (auth()->id() !== $user->id)
                    <x-button
                        type="button"
                        variant="danger"
                        x-data
                        x-on:click="$dispatch('open-modal', 'delete-team-member')"
                    >
                        Delete
                    </x-button>
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
                                    Position
                                </dt>

                                <dd class="mt-1 text-sm text-stone-900 dark:text-stone-100">
                                    {{ $user->position ?? '—' }}
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
        </div>

        @if (auth()->id() !== $user->id)
            <x-modal name="delete-team-member">
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                        Delete Team Member
                    </h2>

                    <p class="text-sm text-stone-600 dark:text-stone-400">
                        Are you sure you want to delete {{ $user->name }}?
                    </p>

                    <div class="flex justify-end gap-3">
                        <x-button
                            type="button"
                            variant="secondary"
                            x-on:click="$dispatch('close-modal', 'delete-team-member')"
                        >
                            Cancel
                        </x-button>

                        <form
                            method="POST"
                            action="{{ route('team.destroy', $user) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <x-button
                                type="submit"
                                variant="danger"
                            >
                                Delete Team Member
                            </x-button>
                        </form>
                    </div>
                </div>
            </x-modal>
        @endif
    </x-layouts.app.content>
</x-layouts.app>