@props([
	'padding' => true,
])

<div
	{{ $attributes->merge([
		'class' => implode(' ', [
			'rounded-sm border border-stone-200 bg-white',
			'dark:border-stone-800 dark:bg-stone-900',
			$padding ? 'p-6' : '',
		]),
	]) }}
>
	{{ $slot }}
</div>