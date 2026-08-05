@props([
	'title',
	'description' => null,
])

<div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
	<div>
		<h1 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">
			{{ $title }}
		</h1>

		@if ($description)
			<p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500 dark:text-stone-400">
				{{ $description }}
			</p>
		@endif
	</div>

	@if (isset($actions))
		<div class="shrink-0">
			{{ $actions }}
		</div>
	@endif
</div>