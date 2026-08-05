@props([
	'label' => null,
	'name',
	'type' => 'text',
	'placeholder' => null,
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
			'class' => 'block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder:text-slate-400 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-100 disabled:bg-slate-100 disabled:text-slate-400',
		]) }}
	>

	<x-form.error :name="$name" />
</div>