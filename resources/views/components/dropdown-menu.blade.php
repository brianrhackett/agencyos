@props([
	'align' => 'right',
	'width' => 'w-40',
])

@php
	$alignment = $align === 'left'
		? 'left-0'
		: 'right-0';
@endphp

<div
	x-data="{ open: false }"
	class="relative inline-block text-left"
>
	<button
		type="button"
		@click="open = !open"
		@click.outside="open = false"
		class="rounded-sm p-2 text-stone-500 hover:bg-stone-100 hover:text-stone-900 dark:hover:bg-stone-800 dark:hover:text-stone-100"
	>
		<x-heroicon-o-ellipsis-horizontal class="size-5" />
	</button>

	<div
		x-cloak
		x-show="open"
		x-transition.origin.top.right
		class="absolute top-[50%] right-[36px] translate-y-[-50%] {{ $alignment }} z-30 mt-2 {{ $width }} rounded-sm border border-stone-200 bg-white py-1 dark:border-stone-800 dark:bg-stone-950"
	>
		{{ $slot }}
	</div>
</div>