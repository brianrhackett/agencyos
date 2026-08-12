<x-layouts.app>
    <x-layouts.app.content
        title="Calendar"
        description="View project deadlines, milestones, meetings, and assigned work."
    >
        <x-slot:actions>
            <x-button>
                <x-heroicon-o-plus class="h-4 w-4" />

                New Event
            </x-button>
        </x-slot:actions>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_22rem]">
            <x-card :padding="false">
                <div class="flex flex-col gap-4 border-b border-stone-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                    <div>
                        <h2 class="text-xl font-bold text-stone-900 dark:text-stone-100">
                            {{ $currentMonth->format('F Y') }}
                        </h2>

                        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                            Project schedule and agency deadlines
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a
                            type="button"
                            class="rounded-sm border border-stone-300 p-2 text-stone-500 transition-colors hover:bg-stone-100 hover:text-stone-900 dark:border-stone-700 dark:text-stone-400 dark:hover:bg-stone-900 dark:hover:text-stone-100"
                            aria-label="Previous month"
                            href="{{ route('calendar.index', [
                                'month' => $currentMonth->copy()->subMonth()->format('Y-m')
                            ]) }}"
                        >
                            <x-heroicon-o-chevron-left class="h-4 w-4" />
                        </a>

                        <a
                            type="button"
                            class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-200 dark:hover:bg-stone-900"
                            href="{{ route('calendar.index', [
                                'month' => now()->format('Y-m')
                            ]) }}"
                        >
                            Today
                        </a>

                        <a
                            type="button"
                            class="rounded-sm border border-stone-300 p-2 text-stone-500 transition-colors hover:bg-stone-100 hover:text-stone-900 dark:border-stone-700 dark:text-stone-400 dark:hover:bg-stone-900 dark:hover:text-stone-100"
                            aria-label="Next month"
                            href="{{ route('calendar.index', [
                                'month' => $currentMonth->copy()->addMonth()->format('Y-m')
                            ]) }}"
                        >
                            <x-heroicon-o-chevron-right class="h-4 w-4" />
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-7 border-b border-stone-200 bg-stone-50 dark:border-stone-800 dark:bg-stone-900">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                        <div class="border-r border-stone-200 px-3 py-3 text-center text-xs font-bold uppercase tracking-wider text-stone-500 last:border-r-0 dark:border-stone-800 dark:text-stone-400">
                            {{ $dayName }}
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7">
                    @foreach ($days as $date)
                        
                            @php
                                $dayEvents = $events->where(
                                    'date',
                                    $date->toDateString()
                                );
                                  
                            @endphp

                            <div
                                @class([
                                    'min-h-32 border-b border-r border-stone-200 p-3 last:border-r-0 dark:border-stone-800',
                                    'bg-white dark:bg-stone-950' => ($date->format('n') === $currentMonth->format('n')),
                                    'bg-stone-50 dark:bg-stone-900' => ($date->format('n') != $currentMonth->format('n')),
                                ])
                            >
                                <div class="flex items-start justify-between">
                                    @if ($date->format('Mj') === now()->format('Mj'))
                                        <span class="flex h-6 w-6 items-center justify-center rounded-sm bg-indigo-600 text-xs font-bold text-white">
                                            {{ $date->format('j') }}
                                        </span>
                                    @else
                                        <span
                                            @class([
                                                'text-sm font-semibold',
                                                'text-stone-900 dark:text-stone-100' => ($date->format('n') === $currentMonth->format('n')),
                                                'text-stone-400 dark:text-stone-600' => ($date->format('n') != $currentMonth->format('n')),
                                            ])
                                        >
                                            {{ $date->format('j') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 space-y-2">
                                    @foreach ($dayEvents as $event)
                                        <a href="{{ $event['url'] }}">
                                            <div
                                                @class([
                                                    'rounded-sm border px-2 py-1.5 text-xs font-semibold mb-2',
                                                    $event["variant"] => !$event['overdue'],
                                                    'border-red-200 bg-red-50 text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-300' => $event['overdue'],
                                                ])
                                            >
                                                <p class="truncate">
                                                    {{ $event['title'] }}
                                                </p>

                                                <p class="mt-1 text-[10px] font-medium opacity-70">
                                                    {{ $event['type'] }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                    @endforeach
                </div>
            </x-card>

            <div class="space-y-6">
                <x-card title="Upcoming">
                    <ul class="divide-y divide-stone-200 dark:divide-stone-800 mt-4">
                        @foreach ($upcomingEvents as $event)
                            <li class="flex gap-4 py-4 first:pt-0">
                                <div class="w-12 shrink-0 text-center">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                        {{ date('M', strtotime($event['date'])) }}
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-stone-900 dark:text-stone-100">
                                        {{ date('j', strtotime($event['date'])) }}
                                    </p>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-stone-900 dark:text-stone-100">
                                        {{ $event['title'] }}
                                    </p>

                                    <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                        {{ $event['client'] }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-card>

                <x-card title="Calendar Key">
                    <div class="space-y-3 my-4">
                        <div class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-sm bg-indigo-600"></span>

                            <span class="text-sm text-stone-600 dark:text-stone-300">
                                Milestone
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-sm bg-stone-500"></span>

                            <span class="text-sm text-stone-600 dark:text-stone-300">
                                Task
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-sm bg-amber-500"></span>

                            <span class="text-sm text-stone-600 dark:text-stone-300">
                                Project
                            </span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-sm bg-red-500"></span>

                            <span class="text-sm text-stone-600 dark:text-stone-300">
                                Overdue
                            </span>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </x-layouts.app.content>
</x-layouts.app>