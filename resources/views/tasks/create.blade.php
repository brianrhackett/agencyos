<x-layouts.app>
	<x-layouts.app.content
		title="Add Task"
		:description="$milestone
			? 'Add a task to ' . $milestone->name . '.'
			: ($project
                ? 'Add a task to ' . $project->name . '.'
                : 'Create a new task and assign it to a project.')"
	>
		<form
			method="POST"
			action="{{ $milestone
				? route('milestones.tasks.store', $milestone)
				: ($project
                    ? route('projects.tasks.store', $project) 
                    : route('tasks.store') )}}"
		>
			@csrf

			<x-card>
				@include('tasks._form')

				<div class="mt-6 flex gap-3 border-t border-stone-200 pt-6 dark:border-stone-800">
					<x-button type="submit">
						Add Task
					</x-button>

					<x-button
						href="{{ $milestone
							? route('milestones.show', $milestone)
							: ($project
                                ? route('projects.show', $project) 
                                : route('tasks.index')) }}"
						variant="ghost"
					>
						Cancel
					</x-button>
				</div>
			</x-card>
		</form>
	</x-layouts.app.content>
</x-layouts.app>