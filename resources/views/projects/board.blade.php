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

				<x-badge :variant="$project->priority->badgeVariant()">
					{{ ucfirst($project->priority->label()) }} priority
				</x-badge>
			</div>

			<div class="flex items-center justify-end gap-3">
				<x-button
					href="{{ route('projects.show', $project) }}"
					variant="primary"
                    icon="circle-stack"
				>
                    Overview
				</x-button>
				@can('update', $project)
					<x-button
						href="{{ route('projects.edit', $project) }}"
						variant="secondary"
                        icon="pencil"
					>
						Edit Project
					</x-button>
				@endcan

				@can('delete', $project)
					<x-button
						type="button"
						variant="danger"
						x-data
						x-on:click="$dispatch('open-modal', 'confirm-delete')"
                        icon="trash"
					>
						Delete
					</x-button>
					
					<x-delete-modal
						type="project"
						name="{{$project->name}}"
						:action="route('projects.destroy', $project)"
					/>
				@endcan
			</div>
		</div>
  
        <div class="flex gap-5 overflow-x-auto pb-4">
            @foreach (\App\Enums\TaskStatus::cases() as $status)
                <x-card>
                    <div class="">
                        <div class="mb-3 flex items-center justify-between w-full">
                            <h2 class="font-bold">
                                {{ $status->label() }}
                            </h2>

                            <span class="text-sm text-stone-500">
                                {{ $tasks->get($status->value, collect())->count() }}
                            </span>
                        </div>

                        <div class="space-y-3">
                            @foreach ($tasks->get($status->value, collect()) as $task)
                                <div class="
                                    grid grid-cols-1 gap-3
                                    border-1 border-stone-100 text-stone-800
                                    text-sm font-bold block p-3 rounded-sm my-3 bg-stone-50 
                                    dark:bg-stone-900 flex items-center dark:text-stone-200 
                                ">
                                    @can('edit', $task)
                                        <a href="{{route('tasks.edit', $task)}}">{{ $task->title }}</a>
                                    @else
                                        <div>{{ $task->title }}</div>
                                    @endcan
                                    <div class="font-normal text-xs text-stone-500 dark:text-stone-400">{{ $task->assignedTo->name }}</div>
                                    <div class="font-normal text-xs text-stone-500 dark:text-stone-400">
                                        <x-heroicon-o-calendar class="size-4 float-left mr-1" />
                                        {{ $task->due_date->format('M j, Y') }}
                                    </div>
                                    @if( !empty($task->milestone) )
                                        <div class="font-bold text-xs text-stone-500 dark:text-stone-400">
                                            Milestone: {{ $task->milestone->name }}
                                        </div>
                                    @endif
                                    <div class="text-right">
                                        <x-badge :variant="$task->priority->badgeVariant()">
                                            {{ $task->priority->label() }}
                                        </x-badge>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </x-layouts.app.content>
</x-layouts.app>