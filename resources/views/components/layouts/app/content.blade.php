<div class="border-b-1 border-stone-200 pb-8 dark:border-stone-800">
	<div class="flex items-start justify-between">
		<div>
			<h1 class="text-3xl font-extrabold tracking-tight text-stone-900 dark:text-white">{{ $title }}</h1>
			<p class="mt-2 max-w-2xl text-sm leading-6 text-stone-500 dark:text-stone-400">{{ $description }}</p>
		</div>

		<div class="shrink-0">
			{{ $actions ?? '' }}
		</div>
	</div>
</div>

<div class="mt-8">
	{{ $slot }}
</div>