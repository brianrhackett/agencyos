<div class="space-y-6">
	<x-input
		name="title"
		label="Task Title"
		value="{{ old('title', $task->title ?? '') }}"
		required
	/>

	<x-textarea
		name="description"
		label="Description"
	>{{ old('description', $task->description ?? '') }}</x-textarea>

    @if (!isset($task->project))
        <div class="grid gap-6 md:grid-cols-2">
            <x-select
                name="project_id"
                label="Project"
                required
            >
                <option value="">Select a project</option>

                @foreach ($projects as $projectOption)
                    <option
                        value="{{ $projectOption->id }}"
                        @selected(old('project_id') == $projectOption->id)
                    >
                        {{ $projectOption->name }}
                    </option>
                @endforeach
            </x-select>

            <x-select
                name="milestone_id"
                label="Milestone"
            >
                <option value="">No milestone</option>

                @foreach ($projects as $projectOption)
                    @foreach ($projectOption->milestones as $milestoneOption)
                        <option
                            value="{{ $milestoneOption->id }}"
                            @selected(old('milestone_id') == $milestoneOption->id)
                        >
                            {{ $projectOption->name }} — {{ $milestoneOption->name }}
                        </option>
                    @endforeach
                @endforeach
            </x-select>
        </div>
    @endif

    <div class="grid gap-6 md:grid-cols-2">
		<x-select
			name="assigned_to"
			label="Assigned To"
		>
			<option value="">Unassigned</option>

			@foreach ($assignees as $assignee)
				<option
					value="{{ $assignee->id }}"
					@selected(old('assigned_to', $task->assigned_to ?? '') == $assignee->id)
				>
					{{ $assignee->name }}
				</option>
			@endforeach
		</x-select>

		<x-select
			name="status"
			label="Status"
			required
		>
			@foreach (\App\Enums\TaskStatus::cases() as $status)
				<option
					value="{{ $status->value }}"
					@selected(
						old(
							'status',
							isset($task)
								? $task->status->value
								: \App\Enums\TaskStatus::ToDo->value
						) === $status->value
					)
				>
					{{ $status->label() }}
				</option>
			@endforeach
		</x-select>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-select
			name="priority"
			label="Priority"
			required
		>
			@foreach (\App\Enums\TaskPriority::cases() as $priority)
				<option
					value="{{ $priority->value }}"
					@selected(
						old(
							'priority',
							isset($task)
								? $task->priority->value
								: \App\Enums\TaskPriority::Normal->value
						) === $priority->value
					)
				>
					{{ $priority->label() }}
				</option>
			@endforeach
		</x-select>

		<div></div>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-input
			name="estimated_hours"
			label="Estimated Hours"
			type="number"
			step="0.25"
			min="0"
			value="{{ old('estimated_hours', $task->estimated_hours ?? '') }}"
		/>

		<x-input
			name="actual_hours"
			label="Actual Hours"
			type="number"
			step="0.25"
			min="0"
			value="{{ old('actual_hours', $task->actual_hours ?? '') }}"
		/>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-input
			name="start_date"
			label="Start Date"
			type="date"
			value="{{ old(
				'start_date',
				isset($task?->start_date)
					? $task->start_date->format('Y-m-d')
					: ''
			) }}"
		/>

		<x-input
			name="due_date"
			label="Due Date"
			type="date"
			value="{{ old(
				'due_date',
				isset($task?->due_date)
					? $task->due_date->format('Y-m-d')
					: ''
			) }}"
		/>
	</div>

	<input
		type="hidden"
		name="return_to"
		value="{{ old('return_to', url()->previous()) }}"
	>
</div>