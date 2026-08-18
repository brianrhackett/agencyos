<x-layouts.app>
	<x-layouts.app.content
		:title="'Edit ' . $milestone->name"
		:description="'Update milestone for ' . $milestone->project->name . '.'"
	>
		<form
			method="POST"
			action="{{ route('milestones.update', $milestone) }}"
		>
			@csrf
			@method('PUT')

			<x-card>
				@include('milestones._form', ['milestone' => $milestone])

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