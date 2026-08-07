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
			<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
				@foreach ($summaryCards as $card)
					<x-card title="{{ $card['title'] }}">
						<p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
							{{ $card['value'] }}
						</p>
					</x-card>
				@endforeach
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 my-8">
				<x-card title="Projects Needing Attention">
					<ul class="divide-y divide-stone-200 dark:divide-stone-800 mt-4">
						@foreach ($projectsNeedingAttention as $project)
							<li class="flex items-start justify-between py-4 first:pt-0">
								<div>
									<h3 class="font-semibold text-stone-900 dark:text-stone-100">
										{{ $project['project_name'] }}
									</h3>

									<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
										{{ $project['client_name'] }}
									</p>
								</div>

								<div class="text-right">
									<p class="text-sm font-medium {{ $project['text_class'] }}">
										{{ $project['attention_text'] }}
									</p>

									<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
										{{ $project['sub_text'] }}
									</p>
								</div>
							</li>
						@endforeach
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
						@foreach ($upcomingMilestones as $milestone)
							<li class="flex items-center gap-4 py-4 first:pt-0">
								<div class="w-14 shrink-0 rounded-sm border border-stone-200 bg-stone-50 py-2 text-center dark:border-stone-700 dark:bg-stone-900">
									<p class="text-[10px] font-semibold uppercase tracking-wider text-stone-500">
										{{ $milestone->due_date->format('M') }}
									</p>

									<p class="text-xl font-bold text-stone-900 dark:text-stone-100">
										{{ $milestone->due_date->format('j') }}
									</p>
								</div>

								<div class="min-w-0 flex-1">
									<h3 class="truncate font-semibold text-stone-900 dark:text-stone-100">
										{{ $milestone->name }}
									</h3>

									<p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
										{{ $milestone->project->client->name }}
									</p>
								</div>

								@if($milestone->due_date->isToday())
									<p class="text-sm font-medium text-red-600">
										Today
									</p>
								@else
									<p class="text-sm font-medium">
										{{ ceil(now()->diffInDays($milestone->due_date)) }} day(s)
									</p>
								@endif
							</li>
						@endforeach
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
						@foreach ($recentActivity as $activity)
							<li class="flex items-start gap-4 py-4 first:pt-0">
								<div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
									@switch($activity['type'])
										@case('task_completed')
											<x-heroicon-o-check-circle class="h-4 w-4" />
											@break

										@case('files_uploaded')
											<x-heroicon-o-arrow-up-tray class="h-4 w-4" />
											@break

										@case('comment_added')
											<x-heroicon-o-chat-bubble-left-ellipsis class="h-4 w-4" />
											@break

										@case('milestone_completed')
											<x-heroicon-o-flag class="h-4 w-4" />
											@break
										@case('client_user_added')
											<x-heroicon-o-user-plus class="h-4 w-4" />
											@break
									@endswitch
								</div>

								<div class="min-w-0 flex-1">
									<p class="text-sm text-stone-900 dark:text-stone-100">
										@foreach ($activity['content'] as $part)
											@if ($part['bold'])
												<span class="font-semibold">{{ $part['text'] }}</span>
											@else
												{{ $part['text'] }}
											@endif
										@endforeach
									</p>

									<p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
										{{ $activity['time'] }}
									</p>
								</div>
							</li>
						@endforeach
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