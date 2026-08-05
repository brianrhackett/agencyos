@props([
	'for',
	'required' => false,
])

<label
	for="{{ $for }}"
	{{ $attributes->merge([
		'class' => 'mb-2 block text-sm font-semibold text-slate-700',
	]) }}
>
	{{ $slot }}

	@if ($required)
		<span class="ml-0.5 text-red-500">*</span>
	@endif
</label>