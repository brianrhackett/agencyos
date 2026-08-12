@props([
	'viewRoute' => null,
	'editRoute' => null,
	'deleteRoute' => null,
	'name',
])

<div x-data="{ modalOpen: false }">
	<x-dropdown-menu>
		@if ($viewRoute)
			<x-dropdown-menu.item :href="$viewRoute">
				View
			</x-dropdown-menu.item>
		@endif

		@if ($editRoute)
			<x-dropdown-menu.item :href="$editRoute">
				Edit
			</x-dropdown-menu.item>
		@endif

		@if ($deleteRoute)
			<x-dropdown-menu.item
				danger
				@click="modalOpen = true"
			>
				Delete
			</x-dropdown-menu.item>
		@endif
	</x-dropdown-menu>

	@if ($deleteRoute)
		<x-modal show="modalOpen" maxWidth="md">
			<div class="p-6">
				<h2 class="text-base font-semibold text-stone-900 dark:text-stone-100">
					Delete {{ $name }}?
				</h2>

				<p class="mt-2 text-sm leading-6 text-stone-600 dark:text-stone-400">
					You're about to delete
					<span class="font-medium text-stone-900 dark:text-stone-100">
						{{ $name }}
					</span>.
					This action cannot be undone.
				</p>
			</div>

			<div class="flex justify-end gap-2 border-t border-stone-200 bg-stone-50 px-6 py-4 dark:border-stone-800 dark:bg-stone-900/50">
				<x-button
					type="button"
					variant="ghost"
					@click="modalOpen = false"
				>
					Cancel
				</x-button>

				<form method="POST" action="{{ $deleteRoute }}">
					@csrf
					@method('DELETE')

					<x-button
						type="submit"
						variant="danger"
					>
						Delete
					</x-button>
				</form>
			</div>
		</x-modal>
	@endif
</div>