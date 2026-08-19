<x-layouts.app>
	<x-layouts.app.content
		title="Tasks"
		description="Overview of all Tasks"
	>
        <x-slot:actions>
            <x-button
                    href="{{ route('tasks.index') }}"
                    variant="success"
                >
                <x-heroicon-o-circle-stack class="h-4 w-4" />

                Overview
            </x-button>
            @can('create', App\Models\Task::class)
                <x-button
                    href="{{ route('tasks.create') }}"
                >
                    <x-heroicon-o-plus class="h-4 w-4" />

                    New Task
                </x-button>
            @endcan
        </x-slot:actions>
        <div class="flex gap-5 overflow-x-auto pb-4">
            @foreach (\App\Enums\TaskStatus::cases() as $status)
                <x-card>
                    <div data-board-column class="flex h-full flex-col">
                        <div class="mb-3 flex items-center justify-between w-full">
                            <h2 class="font-bold">
                                {{ $status->label() }}
                            </h2>

                            <span class="task-count text-sm text-stone-500">
                                {{ $tasks->get($status->value, collect())->count() }}
                            </span>
                        </div>

                        <div class="space-y-3 flex-1 task-column" data-status="{{$status->value}}">
                            @foreach ($tasks->get($status->value, collect()) as $task)
                                <div 
                                    data-task-id="{{ $task->id }}"
                                    class="
                                        task-card cursor-grab active:cursor-grabbing
                                        grid grid-cols-1 gap-3
                                        border-1 border-stone-100 text-stone-800
                                        text-sm font-bold block p-3 rounded-sm my-3 bg-stone-50 
                                        dark:bg-stone-900 flex items-center dark:text-stone-200 
                                        dark:border-stone-800"
                                >
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
                                    <div class="font-bold text-xs text-stone-500 dark:text-stone-400">
                                        Project: {{ $task->project->name }}
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