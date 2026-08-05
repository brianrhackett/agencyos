@props([
	'type' => 'button',
	'variant' => 'primary',
])

@php
	$baseClasses = 'inline-flex items-center justify-center gap-2 rounded-sm px-5 py-3 text-sm font-semibold transition duration-150 focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-50';

	$variants = [
		'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-200 dark:focus:ring-indigo-500/30',
		'secondary' => 'border border-stone-300 bg-white text-stone-700 hover:bg-stone-50 focus:ring-stone-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:hover:bg-stone-800 dark:focus:ring-stone-700',
		'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-200 dark:focus:ring-red-500/30',
		'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-200 dark:focus:ring-emerald-500/30',
		'ghost' => 'text-stone-700 hover:bg-stone-100 focus:ring-stone-200 dark:text-stone-200 dark:hover:bg-stone-800 dark:focus:ring-stone-700',
	];
@endphp

<button
	type="{{ $type }}"
	{{ $attributes->merge([
		'class' => $baseClasses . ' ' . $variants[$variant],
	]) }}
>
	{{ $slot }}
</button>