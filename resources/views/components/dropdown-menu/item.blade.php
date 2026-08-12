@props([
	'href' => null,
	'danger' => false,
	'type' => 'button',
])

@php
	$classes = $danger
		? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40'
		: 'text-stone-700 hover:bg-stone-50 dark:text-stone-300 dark:hover:bg-stone-900';
@endphp

@if ($href)
	<a
		href="{{ $href }}"
		{{ $attributes->class([
			'block w-full px-3 py-2 text-left text-sm',
			$classes,
		]) }}
	>
		{{ $slot }}
	</a>
@else
	<button
		type="{{ $type }}"
		{{ $attributes->class([
			'block w-full px-3 py-2 text-left text-sm',
			$classes,
		]) }}
	>
		{{ $slot }}
	</button>
@endif