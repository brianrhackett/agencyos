@props([
	'id' => null,
])

<p
	@if ($id)
		id="{{ $id }}"
	@endif
	{{ $attributes->merge([
		'class' => 'mt-2 text-sm text-slate-500',
	]) }}
>
	{{ $slot }}
</p>