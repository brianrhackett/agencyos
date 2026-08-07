@props([
	'padding' => true,
	'title' => ''
])

<div
	{{ $attributes->merge([
		'class' => implode(' ', [
			'rounded-sm border border-stone-200 bg-white',
			'dark:border-stone-800 dark:bg-stone-950',
			'min-w-0 flex-1',
			$padding ? 'p-6' : '',
		]),
	]) }}
>

	@if ($title)
		<h3 class="text-sm font-medium text-stone-500 dark:text-stone-400">
			{{ $title }}
		</h3>
	@endif

	{{ $slot }}
</div>