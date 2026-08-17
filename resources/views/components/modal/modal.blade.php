@props([
	'name',
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
	x-data="{ modalOpen: false }"
	x-cloak
	x-show="modalOpen"
	x-on:open-modal.window="
		if ($event.detail === '{{ $name }}') {
			modalOpen = true
		}
	"
	x-on:close-modal.window="
		if ($event.detail === '{{ $name }}') {
			modalOpen = false
		}
	"
	x-on:keydown.escape.window="modalOpen = false"
	class="fixed inset-0 z-50"
>
	<div
		class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm"
		x-on:click="modalOpen = false"
	></div>

	<div class="flex min-h-screen items-center justify-center p-6 whitespace-normal text-left">
		<div
			{{ $attributes->merge([
				'class' => 'relative w-full ' . $widths[$maxWidth] . ' rounded-sm border border-stone-200 bg-white dark:bg-stone-950 dark:border-stone-700 dark:text-stone-400',
			]) }}
		>
			{{ $slot }}
		</div>
	</div>
</div>