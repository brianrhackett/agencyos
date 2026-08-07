<x-layouts.app>
	<x-layouts.app.content
        title="Dashboard"
        description="Manage your agency at a glance."
    >

		<x-slot:actions>
			<x-button>
				<x-heroicon-o-plus class="h-4 w-4" />
				New Project
			</x-button>
		</x-slot>

		<div class="">
			<h2 class="text-xl">Here&rsquo;s what needs your attention today.</h2>
			@php
				$stats = [
					[
						'label' => 'Total Clients',
						'value' => 24,
					],
					[
						'label' => 'Active Projects',
						'value' => 12,
					],
					[
						'label' => 'Tasks Due Today',
						'value' => 7,
					],
					[
						'label' => 'Awaiting Approval',
						'value' => 4,
					],
				];
			@endphp
			<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
				@foreach ($stats as $stat)
					<x-card title="{{ $stat['label'] }}">
						<p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
							{{ $stat['value'] }}
						</p>
					</x-card>
				@endforeach
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 my-8">
				<x-card title="Projects Needing Attention">
					<ul class="divide-y divide-stone-200 dark:divide-stone-800 mt-4">
						<li class="flex items-start justify-between py-4 first:pt-0">
							<div>
								<h3 class="font-semibold text-stone-900 dark:text-stone-100">
									Agency Website Redesign
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									Acme Corporation
								</p>
							</div>

							<div class="text-right">
								<p class="text-sm font-medium text-red-600">
									2 overdue tasks
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									Due 3 days ago
								</p>
							</div>
						</li>

						<li class="flex items-start justify-between py-4">
							<div>
								<h3 class="font-semibold text-stone-900 dark:text-stone-100">
									Marketing Site Refresh
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									GreenLeaf Co.
								</p>
							</div>

							<div class="text-right">
								<p class="text-sm font-medium text-amber-600">
									Client approval needed
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									Waiting 4 days
								</p>
							</div>
						</li>

						<li class="flex items-start justify-between py-4 last:pb-0">
							<div>
								<h3 class="font-semibold text-stone-900 dark:text-stone-100">
									Mobile App Launch
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									Wave Industries
								</p>
							</div>

							<div class="text-right">
								<p class="text-sm font-medium text-indigo-600">
									Milestone tomorrow
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									Needs review
								</p>
							</div>
						</li>
					</ul>
					<div class="mt-6 border-t border-stone-200 pt-4 dark:border-stone-800">
						<a
							href="{{ route('dashboard') }}"
							class="text-sm font-medium 
									text-indigo-600 transition hover:text-indigo-700
									dark:text-indigo-300 hover:dark:text-indigo-200"
						>
							View all projects →
						</a>
					</div>
				</x-card>
				<x-card title="Upcoming Milestones">
					<ul class="divide-y divide-stone-200 dark:divide-stone-800 mt-4">
						<li class="flex items-center gap-4 py-4 first:pt-0">
							<div class="w-14 shrink-0 rounded-sm border border-stone-200 bg-stone-50 py-2 text-center dark:border-stone-700 dark:bg-stone-900">
								<p class="text-[10px] font-semibold uppercase tracking-wider text-stone-500">
									Aug
								</p>

								<p class="text-xl font-bold text-stone-900 dark:text-stone-100">
									12
								</p>
							</div>

							<div class="min-w-0 flex-1">
								<h3 class="truncate font-semibold text-stone-900 dark:text-stone-100">
									Homepage Approved
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									Acme Corporation
								</p>
							</div>

							<p class="text-sm font-medium text-red-600">
								Today
							</p>
						</li>

						<li class="flex items-center gap-4 py-4">
							<div class="w-14 shrink-0 rounded-sm border border-stone-200 bg-stone-50 py-2 text-center dark:border-stone-700 dark:bg-stone-900">
								<p class="text-[10px] font-semibold uppercase tracking-wider text-stone-500">
									Aug
								</p>

								<p class="text-xl font-bold text-stone-900 dark:text-stone-100">
									14
								</p>
							</div>

							<div class="min-w-0 flex-1">
								<h3 class="truncate font-semibold text-stone-900 dark:text-stone-100">
									Content Delivery
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									GreenLeaf Co.
								</p>
							</div>

							<p class="text-sm text-stone-500">
								2 days
							</p>
						</li>

						<li class="flex items-center gap-4 py-4">
							<div class="w-14 shrink-0 rounded-sm border border-stone-200 bg-stone-50 py-2 text-center dark:border-stone-700 dark:bg-stone-900">
								<p class="text-[10px] font-semibold uppercase tracking-wider text-stone-500">
									Aug
								</p>

								<p class="text-xl font-bold text-stone-900 dark:text-stone-100">
									18
								</p>
							</div>

							<div class="min-w-0 flex-1">
								<h3 class="truncate font-semibold text-stone-900 dark:text-stone-100">
									Website Launch
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									Wave Industries
								</p>
							</div>

							<p class="text-sm text-stone-500">
								6 days
							</p>
						</li>

						<li class="flex items-center gap-4 py-4 last:pb-0">
							<div class="w-14 shrink-0 rounded-sm border border-stone-200 bg-stone-50 py-2 text-center dark:border-stone-700 dark:bg-stone-900">
								<p class="text-[10px] font-semibold uppercase tracking-wider text-stone-500">
									Aug
								</p>

								<p class="text-xl font-bold text-stone-900 dark:text-stone-100">
									23
								</p>
							</div>

							<div class="min-w-0 flex-1">
								<h3 class="truncate font-semibold text-stone-900 dark:text-stone-100">
									Final QA Review
								</h3>

								<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
									Northwind Studio
								</p>
							</div>

							<p class="text-sm text-stone-500">
								11 days
							</p>
						</li>
					</ul>

					<div class="mt-6 border-t border-stone-200 pt-4 dark:border-stone-800">
						<a
							href="{{ route('dashboard') }}"
							class="text-sm font-medium 
									text-indigo-600 transition hover:text-indigo-700
									dark:text-indigo-300 hover:dark:text-indigo-200"
						>
							View calendar →
						</a>
					</div>
				</x-card>

				<x-card title="Recent Activity" class="col-span-2">
					<ul class="divide-y divide-stone-200 dark:divide-stone-800 mt-4">
						<li class="flex items-start gap-4 py-4 first:pt-0">
							<div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
								<x-heroicon-o-check-circle class="h-4 w-4" />
							</div>

							<div class="min-w-0 flex-1">
								<p class="text-sm text-stone-900 dark:text-stone-100">
									<span class="font-semibold">Sarah Johnson</span>
									completed the task
									<span class="font-semibold">Homepage Design</span>
									for
									<span class="font-semibold">Acme Corporation</span>.
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									12 minutes ago
								</p>
							</div>
						</li>

						<li class="flex items-start gap-4 py-4">
							<div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
								<x-heroicon-o-arrow-up-tray class="h-4 w-4" />
							</div>

							<div class="min-w-0 flex-1">
								<p class="text-sm text-stone-900 dark:text-stone-100">
									<span class="font-semibold">Mike Davis</span>
									uploaded
									<span class="font-semibold">3 files</span>
									to
									<span class="font-semibold">Marketing Site Refresh</span>.
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									43 minutes ago
								</p>
							</div>
						</li>

						<li class="flex items-start gap-4 py-4">
							<div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
								<x-heroicon-o-chat-bubble-left-right class="h-4 w-4" />
							</div>

							<div class="min-w-0 flex-1">
								<p class="text-sm text-stone-900 dark:text-stone-100">
									<span class="font-semibold">Emily Carter</span>
									left a comment on
									<span class="font-semibold">Website Launch</span>.
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									2 hours ago
								</p>
							</div>
						</li>

						<li class="flex items-start gap-4 py-4">
							<div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
								<x-heroicon-o-flag class="h-4 w-4" />
							</div>

							<div class="min-w-0 flex-1">
								<p class="text-sm text-stone-900 dark:text-stone-100">
									The milestone
									<span class="font-semibold">Content Delivery</span>
									was marked complete.
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									Yesterday
								</p>
							</div>
						</li>

						<li class="flex items-start gap-4 py-4 last:pb-0">
							<div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
								<x-heroicon-o-user-plus class="h-4 w-4" />
							</div>

							<div class="min-w-0 flex-1">
								<p class="text-sm text-stone-900 dark:text-stone-100">
									<span class="font-semibold">Brian Hackett</span>
									added
									<span class="font-semibold">Olivia Wilson</span>
									to
									<span class="font-semibold">Wave Industries</span>.
								</p>

								<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
									Yesterday
								</p>
							</div>
						</li>
					</ul>

					<div class="mt-6 border-t border-stone-200 pt-4 dark:border-stone-800">
						<a
							href="#"
							class="text-sm font-medium 
									text-indigo-600 transition hover:text-indigo-700
									dark:text-indigo-300 hover:dark:text-indigo-200"
						>
							View all activity →
						</a>
					</div>
				</x-card>
			</div>

		</div>
	</x-layouts.app.content>
</x-layouts.app>