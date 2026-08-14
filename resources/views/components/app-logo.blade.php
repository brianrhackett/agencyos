@props([
	'height' => 'h-20',
])

<a
	href="{{ url('/') }}"
	class="inline-flex items-center"
	wire:navigate
>
	<img
		src="{{ asset('images/logo/agencyos-logo.svg') }}"
		alt="AgencyOS"
		class="block {{ $height }} w-auto dark:hidden"
	>

	<img
		src="{{ asset('images/logo/agencyos-logo-white.svg') }}"
		alt="AgencyOS"
		class="hidden {{ $height }} w-auto dark:block"
	>
</a>