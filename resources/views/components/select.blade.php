@props([
	'label' => null,
	'name',
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

	<select
		id="{{ $name }}"
		name="{{ $name }}"
		{{ $attributes->merge([
			'class' => 'block w-full rounded-sm border border-stone-300 bg-white px-4 py-3 text-stone-900 transition focus:border-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-100 disabled:bg-stone-100 disabled:text-stone-400 dark:border-stone-700 dark:bg-stone-900 dark:text-white dark:placeholder:text-stone-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20 dark:disabled:bg-stone-800',
		]) }}
	>
		{{ $slot }}
	</select>

    @if ($help)
        <x-form.help-text>
            {{ $help }}
        </x-form.help-text>
    @endif

	<x-form.error :name="$name" />
</div>