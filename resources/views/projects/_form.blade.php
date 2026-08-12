<div class="space-y-6">
	<x-select
		name="client_id"
		label="Client"
		required
	>
		<option value="">Select a client</option>

		@foreach ($clients as $clientOption)
			<option
				value="{{ $clientOption->id }}"
				@selected(old('client_id', $project->client_id ?? '') == $clientOption->id)
			>
				{{ $clientOption->name }}
			</option>
		@endforeach
	</x-select>

	<x-select
		name="project_manager_id"
		label="Project Manager"
	>
		<option value="">No project manager</option>

		@foreach ($projectManagers as $manager)
			<option
				value="{{ $manager->id }}"
				@selected(old('project_manager_id', $project->project_manager_id ?? '') == $manager->id)
			>
				{{ $manager->name }}
			</option>
		@endforeach
	</x-select>

	<x-input
		name="name"
		label="Project Name"
		value="{{ old('name', $project->name ?? '') }}"
		required
	/>

	<x-textarea
		name="description"
		label="Description"
	>{{ old('description', $project->description ?? '') }}</x-textarea>

	<div class="grid gap-6 md:grid-cols-2">
		<x-select
			name="status"
			label="Status"
			required
		>
			@foreach (\App\Enums\ProjectStatus::cases() as $status)
				<option
					value="{{ $status->value }}"
					@selected(old('status', $project->status->value ?? 'planning') === $status->value)
				>
					{{ $status->label() }}
				</option>
			@endforeach
		</x-select>

		<x-select
			name="priority"
			label="Priority"
			required
		>
			@foreach (['low', 'medium', 'high'] as $priority)
				<option
					value="{{ $priority }}"
					@selected(old('priority', $project->priority ?? 'medium') === $priority)
				>
					{{ ucfirst($priority) }}
				</option>
			@endforeach
		</x-select>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-input
			name="budget"
			label="Budget"
			type="number"
			step="0.01"
			min="0"
			value="{{ old('budget', $project->budget ?? '') }}"
		/>

		<div></div>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-input
			name="start_date"
			label="Start Date"
			type="date"
			value="{{ old('start_date', isset($project?->start_date) ? $project->start_date->format('Y-m-d') : '') }}"
		/>

		<x-input
			name="due_date"
			label="Due Date"
			type="date"
			value="{{ old('due_date', isset($project?->due_date) ? $project->due_date->format('Y-m-d') : '') }}"
		/>
	</div>
</div>