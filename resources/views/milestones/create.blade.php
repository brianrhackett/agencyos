<x-layouts.app>
	<x-layouts.app.content
		title="Add Milestone"
		:description="'Add a milestone to ' . $project->name . '.'"
	>
		<form
			method="POST"
			action="{{ route('projects.milestones.store', $project) }}"
		>
			@csrf

			<x-card>
				@include('milestones._form')

				<div class="mt-6 flex gap-3 border-t border-stone-200 pt-6 dark:border-stone-800">
					<x-button type="submit">
						Add Milestone
					</x-button>

					<x-button
						href="{{ route('projects.show', $project) }}"
						variant="ghost"
					>
						Cancel
					</x-button>
				</div>
			</x-card>
		</form>
	</x-layouts.app.content>
</x-layouts.app>