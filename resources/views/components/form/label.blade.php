@props([
	'for',
	'required' => false,
])

<label
	for="{{ $for }}"
	{{ $attributes->merge([
		'class' => 'mb-2 block text-sm font-semibold text-stone-700 dark:text-stone-200',
	]) }}
>
	{{ $slot }}

	@if ($required)
		<span class="ml-0.5 text-red-500">*</span>
	@endif
</label>