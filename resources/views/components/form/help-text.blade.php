@props([
	'id' => null,
])

<p
	@if ($id)
		id="{{ $id }}"
	@endif
	{{ $attributes->merge([
		'class' => 'mt-2 text-sm text-stone-500 dark:text-stone-400',
	]) }}
>
	{{ $slot }}
</p>