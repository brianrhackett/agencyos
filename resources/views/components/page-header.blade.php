@props([
	'title',
	'description' => null,
])

<div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
	<div>
		<h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
			{{ $title }}
		</h1>

		@if ($description)
			<p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
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