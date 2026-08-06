@props([
	'label' => null,
	'name',
	'type' => 'text',
	'placeholder' => null,
	'help' => null,
])

<div>
	@if ($label)
		<x-form.label
			:for="$name"
			:required="$attributes->has('required')"
		>
			{{ $label }}
		</x-form.label>
	@endif

	<input
		id="{{ $name }}"
		name="{{ $name }}"
		type="{{ $type }}"
		placeholder="{{ $placeholder }}"
		{{ $attributes->merge([
			'class' => 'block w-full rounded-sm border border-stone-300 bg-white px-4 py-3 text-stone-900 placeholder:text-stone-400 transition-colors focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 disabled:bg-stone-100 disabled:text-stone-400 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:placeholder:text-stone-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20 dark:disabled:bg-stone-800',
		]) }}
	>

	@if ($help)
		<x-form.help-text>
			{{ $help }}
		</x-form.help-text>
	@endif

	<x-form.error :name="$name" />
</div>