@props([
	'label' => null,
	'name',
	'type' => 'text',
	'placeholder' => null,
	'help' => null,
	'icon' => null,
	'value' => ''
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
	
	<div class="relative">
		@if ($icon)
			<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400 dark:text-stone-500">
				<x-dynamic-component
					:component="'heroicon-o-' . $icon"
					class="size-5"
				/>
			</div>
		@endif
		<input
			id="{{ $name }}"
			name="{{ $name }}"
			type="{{ $type }}"
			value="{{ $value }}"
			placeholder="{{ $placeholder }}"
			{{ $attributes->class([
				'block w-full rounded-sm border border-stone-300 bg-white pr-3 py-3 text-stone-900',
				'placeholder:text-stone-400 transition-colors focus:border-indigo-500 focus:outline-none',
				'focus:ring-2 focus:ring-indigo-200 disabled:bg-stone-100 disabled:text-stone-400',
				'dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:placeholder:text-stone-500',
				'dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20 dark:disabled:bg-stone-800',
				'pl-10' => $icon,
				'pl-3' => !$icon,
			]) }}
		>
	</div>

	@if ($help)
		<x-form.help-text>
			{{ $help }}
		</x-form.help-text>
	@endif

	<x-form.error :name="$name" />
</div>