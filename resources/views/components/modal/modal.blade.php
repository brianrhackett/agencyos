@props([
	'modalOpen' => false,
	'maxWidth' => '2xl',
])

@php
	$widths = [
		'sm' => 'max-w-sm',
		'md' => 'max-w-md',
		'lg' => 'max-w-lg',
		'xl' => 'max-w-xl',
		'2xl' => 'max-w-2xl',
		'3xl' => 'max-w-3xl',
		'4xl' => 'max-w-4xl',
	];
@endphp

<div
	x-cloak
	x-show="{{ $modalOpen ? 'true' : 'modalOpen' }}"
	class="fixed inset-0 z-50"
>
	<div
		class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm"
		@click="modalOpen = false"
	></div>

	<div class="flex whitespace-normal text-left min-h-screen items-center justify-center p-6">
		<div
			{{ $attributes->merge([
				'class' => 'relative w-full ' . $widths[$maxWidth] . ' rounded-sm border border-stone-200 bg-white dark:bg-stone-950 dark:border-stone-700 dark:text-stone-400',
			]) }}
		>
			{{ $slot }}
		</div>
	</div>
</div>