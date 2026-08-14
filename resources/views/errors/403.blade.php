<x-layouts.error title="Access Denied">
	<div class="max-w-lg text-center">
		<p class="text-sm font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
			403
		</p>

		<h1 class="mt-3 text-4xl font-extrabold tracking-tight text-stone-900 dark:text-white">
			Access denied
		</h1>

		<p class="mt-4 text-base text-stone-500 dark:text-stone-400">
			You don't have permission to access this page.
		</p>

		<div class="mt-8 flex items-center justify-center gap-3">
			<a
				href="{{ url()->previous() }}"
				class="inline-flex items-center justify-center rounded-sm border border-stone-300 bg-white px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-300 dark:hover:bg-stone-800"
			>
				Go Back
			</a>

			@if (auth()->check())
				<a
					href="{{ auth()->user()->isClientUser() ? route('projects.index') : route('dashboard') }}"
					class="inline-flex items-center justify-center rounded-sm bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
				>
					Go Home
				</a>
			@endif
		</div>
	</div>
</x-layouts.error>