@props([
	'type' => 'button',
	'variant' => 'primary',
])

@php
	$baseClasses = 'inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold transition duration-150 focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-50';

	$variants = [
		'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-200',
		'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 focus:ring-slate-200',
		'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-200',
		'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-200',
		'ghost' => 'text-slate-700 hover:bg-slate-100 focus:ring-slate-200',
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