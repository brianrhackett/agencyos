<!DOCTYPE html>
<html
	lang="{{ str_replace('_', '-', app()->getLocale()) }}"
	class="bg-white"
>
	<head>
		@include('partials.head')
	</head>

	<body class="min-h-screen bg-white font-sans text-stone-900 antialiased">
		<main class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_minmax(500px,0.9fr)] dark:bg-stone-950">
			<section class="flex items-center justify-center px-6 py-12 sm:px-10 lg:px-16">
				<div class="w-full max-w-md">
					
					<x-app-logo height="h-10" />

					<div class="mt-12">
						{{ $slot }}
					</div>

					<p class="mt-10 text-center text-xs text-stone-500 dark:text-stone-400">
						&copy; {{ now()->year }} AgencyOS. All rights reserved.
					</p>
				</div>
			</section>

			<section class="relative hidden overflow-hidden bg-indigo-700 lg:block dark:bg-stone-950">
				<div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800"></div>

				<div class="absolute -left-32 top-20 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>

				<div class="absolute -bottom-32 right-0 h-[30rem] w-[30rem] rounded-full bg-violet-400/20 blur-3xl"></div>

				<div class="relative flex min-h-screen flex-col justify-between p-12 xl:p-16">
					<img
						src="{{ asset('images/logo/agencyos-logo-white.svg') }}"
						alt="AgencyOS"
						class="h-9 w-auto self-start"
					>

					<div class="max-w-xl">

						<h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white xl:text-5xl">
							Keep your agency moving forward.
						</h1>

						<p class="mt-6 max-w-lg text-lg leading-8 text-indigo-100">
							Bring clients, projects, milestones, tasks, and approvals together in one focused workspace.
						</p>

						<div class="mt-10 grid grid-cols-3 gap-6 border-t border-white/15 pt-8">
							<div>
								<p class="text-lg font-bold text-white">
									Organized
								</p>

								<p class="mt-1 text-sm leading-5 text-indigo-200">
									Projects stay clear and structured.
								</p>
							</div>

							<div>
								<p class="text-lg font-bold text-white">
									Connected
								</p>

								<p class="mt-1 text-sm leading-5 text-indigo-200">
									Teams and clients stay aligned.
								</p>
							</div>

							<div>
								<p class="text-lg font-bold text-white">
									Focused
								</p>

								<p class="mt-1 text-sm leading-5 text-indigo-200">
									Everyone knows what comes next.
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