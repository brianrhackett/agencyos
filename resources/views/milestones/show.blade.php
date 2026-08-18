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

			<div class="flex flex-wrap items-center justify-end gap-3">
				@can('update', $milestone)
					<x-button
						href="{{ route('milestones.edit', $milestone) }}"
						variant="secondary"
						icon="pencil"
					>
						Edit Milestone
					</x-button>
				@endcan

				@can('delete', $milestone)
				 	<x-button
                        type="button"
                        variant="danger"
                        x-data
                        x-on:click="$dispatch('open-modal', 'confirm-delete')"
						icon="trash"
                    >
						Delete Milestone
					</x-button>
					<x-delete-modal
						type="milestone"
						name="Milestone"
						:action="route('milestones.destroy', $milestone)"
					/>
				@endcan
			</div>
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
						<table class="min-w-full divide-y divide-stone-200 dark:divide-stone-800">
							<tbody class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
								@foreach ($milestone->tasks as $task)
									<tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
										<td class="pr-6 py-4">
											<p class="font-medium text-stone-900 dark:text-stone-100">
												{{ $task->title }}
											</p>

											@if ($task->assignedTo)
												<p class="mt-1 text-sm text-stone-500">
													{{ $task->assignedTo->name }}
												</p>
											@endif
										</td>

										<td class="text-center px-6 py-4">
											<x-badge :variant="$task->status->badgeVariant()">
												{{ $task->status->label() }}
											</x-badge>

											@if ($task->due_date)
												<p class="mt-1 text-xs text-stone-500">
													{{ $task->due_date->format('M j, Y') }}
												</p>
											@endif
										</td>
										<td class="pl-6 py-4 text-right">
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
												:returnTo="route('milestones.show', $milestone)" 
											/>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
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