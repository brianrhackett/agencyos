@props([
	'open' => false,
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

@if ($open)
	<div class="fixed inset-0 z-50">
		<div class="absolute inset-0 bg-stone-900/50 backdrop-blur-sm"></div>

		<div class="flex min-h-screen items-center justify-center p-6">
			<div
				{{ $attributes->merge([
					'class' => 'relative w-full ' . $widths[$maxWidth] . ' rounded-sm border border-stone-200 bg-white shadow-2xl',
				]) }}
			>
				{{ $slot }}
			</div>
		</div>
	</div>
@endif