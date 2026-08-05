@props([
	'padding' => true,
])

<div
	{{ $attributes->merge([
		'class' => implode(' ', [
			'rounded-2xl border border-slate-200 bg-white shadow-sm',
			$padding ? 'p-6' : '',
		]),
	]) }}
>
	{{ $slot }}
</div>