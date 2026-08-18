<x-layouts.app>
	<x-layouts.app.content
		:title="'Edit ' . $task->title"
		:description="'Update task details for ' . $task->project->name . '.'"
	>
		<form
			method="POST"
			action="{{ route('tasks.update', $task) }}"
		>
			@csrf
			@method('PUT')

			<x-card>
				@include('tasks._form', [
					'task' => $task,
					'assignees' => $assignees,
				])

				<div class="mt-6 flex gap-3 border-t border-stone-200 pt-6 dark:border-stone-800">
					<x-button type="submit">
						Save Changes
					</x-button>

					<x-button
						href="{{ url()->previous() }}"
						variant="ghost"
					>
						Cancel
					</x-button>
				</div>
			</x-card>
		</form>
	</x-layouts.app.content>
</x-layouts.app>