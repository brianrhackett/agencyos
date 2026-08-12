<div class="space-y-6">
	<x-input
		name="name"
		label="Milestone Name"
		value="{{ old('name', $milestone->name ?? '') }}"
		required
	/>

	<x-textarea
		name="description"
		label="Description"
	>{{ old('description', $milestone->description ?? '') }}</x-textarea>

	<div class="grid gap-6 md:grid-cols-2">
		<x-select
			name="status"
			label="Status"
			required
		>
			@foreach (\App\Enums\MilestoneStatus::cases() as $status)
				<option
					value="{{ $status->value }}"
					@selected(old('status', $milestone->status->value ?? 'not_started') === $status->value)
				>
					{{ $status->label() }}
				</option>
			@endforeach
		</x-select>

		<x-input
			name="sort_order"
			label="Sort Order"
			type="number"
			min="0"
			value="{{ old('sort_order', $milestone->sort_order ?? 0) }}"
		/>
	</div>

	<div class="grid gap-6 md:grid-cols-2">
		<x-input
			name="start_date"
			label="Start Date"
			type="date"
			value="{{ old(
				'start_date',
				isset($milestone?->start_date)
					? $milestone->start_date->format('Y-m-d')
					: ''
			) }}"
		/>

		<x-input
			name="due_date"
			label="Due Date"
			type="date"
			value="{{ old(
				'due_date',
				isset($milestone?->due_date)
					? $milestone->due_date->format('Y-m-d')
					: ''
			) }}"
		/>
	</div>
</div>