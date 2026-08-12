<x-layouts.app>
	<x-layouts.app.content
		:title="$project->name"
		:description="$project->client?->name ?? 'Project overview'"
	>
		<div class="mb-6 flex items-center justify-between">
			<div class="flex items-center gap-3">
				<x-badge :variant="$project->status->badgeVariant()">
					{{ $project->status->label() }}
				</x-badge>

				<span class="text-sm text-stone-500">
					{{ ucfirst($project->priority->label()) }} priority
				</span>
			</div>

			<x-button
				href="{{ route('projects.edit', $project) }}"
				variant="secondary"
			>
				Edit Project
			</x-button>
		</div>

		<div class="grid gap-6 lg:grid-cols-3">
			<div class="space-y-6 lg:col-span-2">
				<x-card>
					<h2 class="mb-4 text-lg font-semibold">
						Project Overview
					</h2>

					@if ($project->description)
						<p class="leading-7 text-stone-600 dark:text-stone-300">
							{{ $project->description }}
						</p>
					@else
						<p class="text-sm text-stone-500">
							No description provided.
						</p>
					@endif
				</x-card>
                <x-card>
                    <div class="mb-4 flex items-center justify-between">
						<div>
							<h2 class="text-lg font-semibold">
								Tasks
							</h2>

							<span class="text-sm text-stone-500">
								{{ $project->directTasks->count() }} total
							</span>	
						</div>
						<x-button
							href="{{ route('projects.tasks.create', $project) }}"
						>
							Add Task
						</x-button>
                    </div>

                    @if ($project->directTasks->isEmpty())
                        <p class="text-sm text-stone-500">
                            No tasks assigned directly to this project.
                        </p>
                    @else
                        <div class="divide-y divide-stone-200 dark:divide-stone-800">
                            @foreach ($project->directTasks as $task)
                                <div class="flex items-center justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                    <div>
                                        <p class="font-medium text-stone-900 dark:text-stone-100">
                                            {{ $task->title }}
                                        </p>

                                        @if ($task->assignedTo)
                                            <p class="mt-1 text-sm text-stone-500">
                                                {{ $task->assignedTo->name }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <x-badge :variant="$task->status->badgeVariant()">
                                            {{ $task->status->label() }}
                                        </x-badge>

                                        @if ($task->due_date)
                                            <p class="mt-1 text-xs text-stone-500">
                                                {{ $task->due_date->format('M j, Y') }}
                                            </p>
                                        @endif
                                    </div>
									<div>
										<x-row-actions
											:viewRoute="route('tasks.show', $task)"
											:editRoute="route('tasks.edit', $task)"
											:deleteRoute="route('tasks.destroy', $task)"
											:name="$task->title"
										/>
									</div>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>
				<x-card>
					<div class="mb-4 flex items-center justify-between">
						<h2 class="text-lg font-semibold">
							Milestones
						</h2>

                        <x-button
                            href="{{ route('projects.milestones.create', $project) }}"
                        >
                            Add Milestone
                        </x-button>
					</div>

					@if ($project->milestones->isEmpty())
						<p class="text-sm text-stone-500">
							No milestones yet.
						</p>
					@else
						<div class="divide-y divide-stone-200 dark:divide-stone-800">
							@foreach ($project->milestones as $milestone)
								<div class="py-4 first:pt-0 last:pb-0">
									<div class="flex items-start justify-between gap-4">
										<div>
											<a 
                                                href="{{ route('milestones.show', $milestone) }}"
                                                class="font-medium text-stone-900 dark:text-stone-100 hover:text-indigo-600"
                                            >
												{{ $milestone->name }}
                                            </a>

											@if ($milestone->due_date)
												<p class="mt-1 text-sm text-stone-500">
													Due {{ $milestone->due_date->format('M j, Y') }}
												</p>
											@endif
										</div>

										<span class="text-sm text-stone-500">
											{{ $milestone->tasks->count() }} tasks
										</span>
                                        <div>
                                            <x-row-actions
                                                :viewRoute="route('milestones.show', $milestone)"
                                                :editRoute="route('milestones.edit', $milestone)"
                                                :deleteRoute="route('milestones.destroy', $milestone)"
                                                :name="$milestone->name"
                                            />
                                        </div>
									</div>
								</div>
							@endforeach
						</div>
					@endif
				</x-card>
			</div>

			<div class="space-y-6">
				<x-card>
					<h2 class="mb-4 text-lg font-semibold">
						Details
					</h2>

					<div class="space-y-4">
						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Client
							</p>

							@if ($project->client)
								<a
									href="{{ route('clients.show', $project->client) }}"
									class="mt-1 block font-medium text-stone-900 hover:text-indigo-600 dark:text-stone-100"
								>
									{{ $project->client->name }}
								</a>
							@else
								<p class="mt-1">—</p>
							@endif
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Project Manager
							</p>

							<p class="mt-1 font-medium">
								{{ $project->projectManager?->name ?? 'Unassigned' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Start Date
							</p>

							<p class="mt-1">
								{{ $project->start_date?->format('M j, Y') ?? '—' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Due Date
							</p>

							<p class="mt-1">
								{{ $project->due_date?->format('M j, Y') ?? '—' }}
							</p>
						</div>

						<div>
							<p class="text-xs font-medium uppercase tracking-wide text-stone-500">
								Budget
							</p>

							<p class="mt-1">
								@if ($project->budget !== null)
									${{ number_format($project->budget, 2) }}
								@else
									—
								@endif
							</p>
						</div>
					</div>
				</x-card>
			</div>
		</div>
	</x-layouts.app.content>
</x-layouts.app>