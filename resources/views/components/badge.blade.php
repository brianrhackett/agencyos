@props([
	'variant' => 'neutral',
])

@php
	$baseClasses = 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold';

	$variants = [
		'neutral' => 'bg-stone-100 text-stone-700',
		'primary' => 'bg-indigo-100 text-indigo-700',
		'success' => 'bg-emerald-100 text-emerald-700',
		'danger' => 'bg-red-100 text-red-700',
		'warning' => 'bg-amber-100 text-amber-700',
		'info' => 'bg-sky-100 text-sky-700',
	];
@endphp

<span
	{{ $attributes->merge([
		'class' => $baseClasses . ' ' . $variants[$variant],
	]) }}
>
	{{ $slot }}
</span>