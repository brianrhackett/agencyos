@props([
	'title',
	'description' => null,
])

<div class="">
	<header class="bg-transparent sm:px-8 ">
		<div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between border-b border-stone-200 pb-8 dark:border-stone-800"">
			<div>
				<h1 class="text-2xl font-bold tracking-tight text-stone-900 dark:text-stone-100">
					{{ $title }}
				</h1>

				@if ($description)
					<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
						{{ $description }}
					</p>
				@endif
			</div>

			<div class="flex flex-col gap-3 sm:flex-row sm:items-center">
				<div class="relative w-full sm:w-72">
					<x-heroicon-o-magnifying-glass
						class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
					/>

					<input
						type="search"
						placeholder="Search AgencyOS..."
						class="w-full rounded-sm border border-stone-300 bg-white py-2.5 pl-10 pr-4 text-sm text-stone-900 outline-none transition-colors placeholder:text-stone-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-950 dark:text-stone-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
					>
				</div>

				@if (isset($actions))
					<div class="shrink-0">
						{{ $actions }}
					</div>
				@endif
			</div>
		</div>
	</header>

	<div class="sm:px-8 py-8">
		{{ $slot }}
	</div>
</div>