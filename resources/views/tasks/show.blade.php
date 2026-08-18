<x-layouts.app>
	<x-layouts.app.content
		:title="$task->title"
		:description="$task->project?->name ?? 'Task details'"
	>
		<div class="mb-6 grid grid-cols-1 gap-3 md:flex items-center justify-between gap-4">
			<div class="flex flex-wrap items-center gap-3">
				<x-badge :variant="$task->status->badgeVariant()">
					{{ $task->status->label() }}
				</x-badge>

				<x-badge :variant="$task->priority->badgeVariant()">
					{{ $task->priority->label() }}
				</x-badge>

				@if ($task->due_date)
					<span class="text-sm text-stone-500 dark:text-stone-400">
						Due {{ $task->due_date->format('M j, Y') }}
					</span>
				@endif
			</div>

			<div class="flex flex-wrap items-center justify-end gap-3">
				@can('update', $task)
					<x-button
						href="{{ route('tasks.edit', $task) }}"
						variant="secondary"
						icon="pencil"
					>
						Edit Task
					</x-button>
				@endcan

				@can('delete', $task)
					<x-button
						type="button"
						variant="danger"
						x-data
						x-on:click="$dispatch('open-modal', 'confirm-delete')"
						icon="trash"
					>
						Delete Task
					</x-button>

					<x-delete-modal
						type="task"
						name="Task"
						:action="route('tasks.destroy', $task)"
					/>
				@endcan
			</div>
		</div>

		<div class="grid gap-6 lg:grid-cols-3">
			<div class="space-y-6 lg:col-span-2">
				<x-card>
					<h2 class="mb-4 text-lg font-semibold text-stone-900 dark:text-stone-100">
						Description
					</h2>

					@if ($task->description)
						<p class="whitespace-pre-line leading-7 text-stone-600 dark:text-stone-300">{{ $task->description }}</p>
					@else
						<p class="text-sm text-stone-500">
							No description provided.
						</p>
					@endif
				</x-card>

				<x-card>
					<div class="mb-4 flex items-center justify-between">
						<div>
							<h2 class="text-lg font-semibold text-stone-900 dark:text-stone-100">
								Comments
							</h2>

							<p class="mt-1 text-sm text-stone-500">
								{{ $task->comments->count() }}
								{{ Str::plural('comment', $task->comments->count()) }}
							</p>
						</div>
					</div>

					<div class="mb-4">
						<form
							method="POST"
							action="{{ route('tasks.comments.store', $task) }}"
							class="space-y-3"
						>
							@csrf

							<x-textarea
								name="body"
								label="Add Comment"
								rows="3"
								placeholder="Write a comment..."
							>
								{{ old('body') }}
							</x-textarea>

							<div class="flex justify-end">
								<x-button type="submit">
									Add Comment
								</x-button>
							</div>
						</form>
					</div>

					@if ($task->comments->isEmpty())
						<p class="border-t border-stone-200 pt-4 text-sm text-stone-500 dark:border-stone-800">
							No comments yet.
						</p>
					@else
						<div class="divide-y divide-stone-200 border-t border-stone-200 dark:divide-stone-800 dark:border-stone-800">
							@foreach ($task->comments as $comment)
								<div class="py-4">
									<div class="flex items-start justify-between gap-4">
										<div>
											<p class="font-medium text-stone-900 dark:text-stone-100">
												{{ $comment->user?->name ?? 'Unknown user' }}
											</p>

											<p class="mt-1 text-xs text-stone-500">
												{{ $comment->created_at->format('M j, Y g:i A') }}
											</p>
										</div>
									</div>

									<p class="mt-3 whitespace-pre-line text-sm leading-6 text-stone-600 dark:text-stone-300">{{ $comment->body }}</p>
								</div>
							@endforeach
						</div>
					@endif
				</x-card>

				<x-card>
					<div class="mb-4 flex items-center justify-between">
						<div>
							<h2 class="text-lg font-semibold text-stone-900 dark:text-stone-100">
								Files
							</h2>

							<p class="mt-1 text-sm text-stone-500">
								{{ $task->files->count() }}
								{{ Str::plural('file', $task->files->count()) }}
							</p>
						</div>
					</div>

					<div class="mb-4">
						<form
							method="POST"
							action="{{ route('tasks.files.store', $task) }}"
							enctype="multipart/form-data"
							class="mb-6"
						>
							@csrf

							<div class="flex items-end gap-3">
								<div class="flex-1">
									<label
										for="file"
										class="mb-1 block text-sm font-medium text-stone-700 dark:text-stone-300"
									>
										Add File
									</label>

									<input
										type="file"
										name="file"
										id="file"
										class="block w-full rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-900
											file:mr-4 file:border-0 file:bg-stone-100 file:px-3 file:py-1 file:text-sm file:font-semibold
											dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:file:bg-stone-800"
									>

									@error('file')
										<p class="mt-1 text-sm text-red-600">
											{{ $message }}
										</p>
									@enderror
								</div>

								<x-button type="submit">
									Upload
								</x-button>
							</div>
						</form>
					</div>

					@if ($task->files->isEmpty())
						<p class="border-t border-stone-200 pt-4 text-sm text-stone-500 dark:border-stone-800">
							No files attached to this task.
						</p>
					@else
						<div class="divide-y divide-stone-200 border-t border-stone-200 dark:divide-stone-800 dark:border-stone-800">
							@foreach ($task->files as $file)
								<div class="flex items-center justify-between gap-4 py-4">
									<div class="min-w-0">
										<a
											href="{{ asset('storage/' . $file->path) }}"
											target="_blank"
											class="font-semibold text-indigo-600 hover:underline dark:text-indigo-400"
										>
											<p class="truncate">
												{{ $file->original_name ?? $file->name }}
											</p>
										</a>

										@if ($file->size)
											<p class="mt-1 text-xs text-stone-500">
												{{ number_format($file->size / 1024, 1) }} KB
											</p>
										@endif
									</div>
								</div>
							@endforeach
						</div>
					@endif
				</x-card>
			</div>

			<div class="space-y-6">
				<x-card>
					<h2 class="mb-5 text-lg font-semibold text-stone-900 dark:text-stone-100">
						Details
					</h2>

					<div class="space-y-5">
						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Client
							</p>

							
								<a
									href="{{ route('projects.show', $task->project) }}"
									class="mt-1 block font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
								>
									{{ $task->project->client->name }}
								</a>
						</div>
						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Project
							</p>

							@if ($task->project)
								<a
									href="{{ route('projects.show', $task->project) }}"
									class="mt-1 block font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
								>
									{{ $task->project->name }}
								</a>
							@else
								<p class="mt-1 text-stone-500">—</p>
							@endif
						</div>

						@if ($task->milestone)
							<div>
								<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
									Milestone
								</p>

								<a
									href="{{ route('milestones.show', $task->milestone) }}"
									class="mt-1 block font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
								>
									{{ $task->milestone->name }}
								</a>
							</div>
						@endif

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Assigned To
							</p>

							<p class="mt-1 font-medium text-stone-900 dark:text-stone-100">
								{{ $task->assignedTo?->name ?? 'Unassigned' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Created By
							</p>

							<p class="mt-1 text-stone-700 dark:text-stone-300">
								{{ $task->createdBy?->name ?? '—' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Start Date
							</p>

							<p class="mt-1 text-stone-700 dark:text-stone-300">
								{{ $task->start_date?->format('M j, Y') ?? '—' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Due Date
							</p>

							<p class="mt-1 text-stone-700 dark:text-stone-300">
								{{ $task->due_date?->format('M j, Y') ?? '—' }}
							</p>
						</div>

						@if ($task->completed_at)
							<div>
								<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
									Completed
								</p>

								<p class="mt-1 text-stone-700 dark:text-stone-300">
									{{ $task->completed_at->format('M j, Y g:i A') }}
								</p>
							</div>
						@endif
					</div>
				</x-card>

				<x-card>
					<h2 class="mb-5 text-lg font-semibold text-stone-900 dark:text-stone-100">
						Time
					</h2>

					<div class="grid grid-cols-2 gap-4">
						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Estimated
							</p>

							<p class="mt-1 text-lg font-semibold text-stone-900 dark:text-stone-100">
								{{ $task->estimated_hours !== null ? $task->estimated_hours . 'h' : '—' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Actual
							</p>

							<p class="mt-1 text-lg font-semibold text-stone-900 dark:text-stone-100">
								{{ $task->actual_hours !== null ? $task->actual_hours . 'h' : '—' }}
							</p>
						</div>
					</div>
				</x-card>

				<x-card>
					<h2 class="mb-5 text-lg font-semibold text-stone-900 dark:text-stone-100">
						Client
					</h2>

					@if ($task->project?->client)
						<a
							href="{{ route('clients.show', $task->project->client) }}"
							class="font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
						>
							{{ $task->project->client->name }}
						</a>
					@else
						<p class="text-sm text-stone-500">
							No client associated.
						</p>
					@endif
				</x-card>
			</div>
		</div>
	</x-layouts.app.content>
</x-layouts.app>