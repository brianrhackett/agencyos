<x-layouts.app>
	<x-layouts.app.content
		:title="$milestone->name"
		:description="'Milestone for ' . $milestone->project->name"
	>
		<div class="mb-6 flex items-center justify-between">
			<div class="flex items-center gap-3">
				<x-badge>
					{{ $milestone->status->label() }}
				</x-badge>

				@if ($milestone->due_date)
					<span class="text-sm text-stone-500 dark:text-stone-400">
						Due {{ $milestone->due_date->format('M j, Y') }}
					</span>
				@endif
			</div>

			@can('update', $milestone)
				<x-button
					href="{{ route('milestones.edit', $milestone) }}"
					variant="secondary"
				>
					Edit Milestone
				</x-button>
			@endcan
		</div>

		<div class="grid gap-6 lg:grid-cols-3">
			<div class="space-y-6 lg:col-span-2">

				{{-- Overview --}}
				<x-card>
					<h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">
						Overview
					</h2>

					@if ($milestone->description)
						<p class="leading-7 text-stone-600 dark:text-stone-300">
							{{ $milestone->description }}
						</p>
					@else
						<p class="text-sm text-stone-500">
							No description provided.
						</p>
					@endif
				</x-card>

				{{-- Tasks --}}
				<x-card>
					<div class="mb-4 flex items-center justify-between">
						<div>
							<h2 class="text-lg font-semibold text-stone-900 dark:text-stone-100">
								Tasks
							</h2>

							<p class="mt-1 text-sm text-stone-500">
								{{ $milestone->tasks->count() }}
								{{ Str::plural('task', $milestone->tasks->count()) }}
							</p>
						</div>
						@can('create', App\Models\Task::class)
							<x-button
								href="{{ route('milestones.tasks.create', $milestone) }}"
								size="sm"
							>
								Add Task
							</x-button>
						@endcan
					</div>

					@if ($milestone->tasks->isEmpty())
						<div class="border-t border-stone-200 pt-4 dark:border-stone-800">
							<p class="text-sm text-stone-500">
								No tasks have been added to this milestone.
							</p>
						</div>
					@else
						<div class="divide-y divide-stone-200 border-t border-stone-200 dark:divide-stone-800 dark:border-stone-800">
							@foreach ($milestone->tasks as $task)
								<div class="flex items-center justify-between gap-6 py-4">
									<div class="min-w-0">
										<p class="truncate font-medium text-stone-900 dark:text-stone-100">
											<a
												href="{{ route('tasks.show', $task) }}"
												class="font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
											>
												{{ $task->title }}
											</a>
										</p>

										<p class="mt-1 text-sm text-stone-500">
											{{ $task->assignedTo?->name ?? 'Unassigned' }}
										</p>
									</div>

									<div class="shrink-0 text-right">
										@if ($task->due_date)
											<p class="text-sm text-stone-600 dark:text-stone-400">
												{{ $task->due_date->format('M j, Y') }}
											</p>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					@endif
				</x-card>
			</div>

			{{-- Sidebar --}}
			<div class="space-y-6">
				<x-card>
					<h2 class="mb-5 text-lg font-semibold text-stone-900 dark:text-stone-100">
						Details
					</h2>

					<div class="space-y-5">
						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Project
							</p>

							<a
								href="{{ route('projects.show', $milestone->project) }}"
								class="mt-1 block font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
							>
								{{ $milestone->project->name }}
							</a>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Client
							</p>

							@if ($milestone->project->client)
								<a
									href="{{ route('clients.show', $milestone->project->client) }}"
									class="mt-1 block font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
								>
									{{ $milestone->project->client->name }}
								</a>
							@else
								<p class="mt-1 text-stone-500">—</p>
							@endif
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Start Date
							</p>

							<p class="mt-1 text-stone-700 dark:text-stone-300">
								{{ $milestone->start_date?->format('M j, Y') ?? '—' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Due Date
							</p>

							<p class="mt-1 text-stone-700 dark:text-stone-300">
								{{ $milestone->due_date?->format('M j, Y') ?? '—' }}
							</p>
						</div>

						@if ($milestone->completed_at)
							<div>
								<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
									Completed
								</p>

								<p class="mt-1 text-stone-700 dark:text-stone-300">
									{{ $milestone->completed_at->format('M j, Y') }}
								</p>
							</div>
						@endif
					</div>
				</x-card>
			</div>
		</div>
	</x-layouts.app.content>
</x-layouts.app>