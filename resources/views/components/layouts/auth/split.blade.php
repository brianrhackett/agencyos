<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('partials.head')
	</head>

	<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
		<main class="grid min-h-screen lg:grid-cols-2">
			<section class="flex items-center justify-center px-6 py-12 sm:px-10 lg:px-16">
				<div class="w-full max-w-md">
					<a
						href="{{ url('/') }}"
						class="mb-12 inline-flex"
						wire:navigate
					>
						<img
							src="{{ asset('images/logo/agencyos-logo.svg') }}"
							alt="AgencyOS"
							class="h-12 w-auto"
						>
					</a>

					{{ $slot }}

					<p class="mt-10 text-center text-xs text-slate-400">
						&copy; {{ now()->year }} AgencyOS. All rights reserved.
					</p>
				</div>
			</section>

			<section class="relative hidden overflow-hidden bg-indigo-700 lg:flex">
				<div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800"></div>

				<div class="absolute -left-24 top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

				<div class="absolute -bottom-28 right-0 h-96 w-96 rounded-full bg-violet-400/20 blur-3xl"></div>

				<div class="relative z-10 flex w-full flex-col justify-between p-14">
					<a
						href="{{ url('/') }}"
						class="inline-flex self-start"
						wire:navigate
					>
						<img
							src="{{ asset('images/logo/agencyos-logo-white.svg') }}"
							alt="AgencyOS"
							class="h-10 w-auto"
						>
					</a>

					<div class="max-w-xl">
						<div class="mb-8 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20">
							<x-heroicon-o-squares-2x2 class="h-7 w-7 text-white" />
						</div>

						<h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white xl:text-5xl">
							Everything your agency needs, all in one place.
						</h1>

						<p class="mt-6 max-w-lg text-lg leading-8 text-indigo-100">
							Manage clients, projects, milestones, tasks, files, and approvals without losing sight of the work that matters.
						</p>

						<div class="mt-10 grid grid-cols-3 gap-6 border-t border-white/15 pt-8">
							<div>
								<p class="text-2xl font-bold text-white">
									One
								</p>

								<p class="mt-1 text-sm text-indigo-200">
									shared workspace
								</p>
							</div>

							<div>
								<p class="text-2xl font-bold text-white">
									Clear
								</p>

								<p class="mt-1 text-sm text-indigo-200">
									client visibility
								</p>
							</div>

							<div>
								<p class="text-2xl font-bold text-white">
									Better
								</p>

								<p class="mt-1 text-sm text-indigo-200">
									project delivery
								</p>
							</div>
						</div>
					</div>

					<p class="text-sm text-indigo-200">
						The operating system for digital agencies.
					</p>
				</div>
			</section>
		</main>

		@fluxScripts
	</body>
</html>