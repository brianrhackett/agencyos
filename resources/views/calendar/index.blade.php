<x-layouts.app>
    @php
        $events = [
            [
                'day' => 3,
                'title' => 'Marketing Site Refresh',
                'type' => 'Milestone',
                'variant' => 'warning',
            ],
            [
                'day' => 6,
                'title' => 'Homepage wireframes due',
                'type' => 'Task',
                'variant' => 'primary',
            ],
            [
                'day' => 8,
                'title' => 'Client review meeting',
                'type' => 'Meeting',
                'variant' => 'neutral',
            ],
            [
                'day' => 12,
                'title' => 'Homepage Approved',
                'type' => 'Milestone',
                'variant' => 'danger',
            ],
            [
                'day' => 14,
                'title' => 'Content Delivery',
                'type' => 'Milestone',
                'variant' => 'primary',
            ],
            [
                'day' => 18,
                'title' => 'Website Launch',
                'type' => 'Milestone',
                'variant' => 'success',
            ],
            [
                'day' => 21,
                'title' => 'QA review',
                'type' => 'Task',
                'variant' => 'neutral',
            ],
            [
                'day' => 23,
                'title' => 'Final QA Review',
                'type' => 'Milestone',
                'variant' => 'primary',
            ],
        ];

        $weeks = [
            [
                ['day' => 27, 'current' => false],
                ['day' => 28, 'current' => false],
                ['day' => 29, 'current' => false],
                ['day' => 30, 'current' => false],
                ['day' => 31, 'current' => false],
                ['day' => 1, 'current' => true],
                ['day' => 2, 'current' => true],
            ],
            [
                ['day' => 3, 'current' => true],
                ['day' => 4, 'current' => true],
                ['day' => 5, 'current' => true],
                ['day' => 6, 'current' => true],
                ['day' => 7, 'current' => true],
                ['day' => 8, 'current' => true],
                ['day' => 9, 'current' => true],
            ],
            [
                ['day' => 10, 'current' => true],
                ['day' => 11, 'current' => true],
                ['day' => 12, 'current' => true],
                ['day' => 13, 'current' => true],
                ['day' => 14, 'current' => true],
                ['day' => 15, 'current' => true],
                ['day' => 16, 'current' => true],
            ],
            [
                ['day' => 17, 'current' => true],
                ['day' => 18, 'current' => true],
                ['day' => 19, 'current' => true],
                ['day' => 20, 'current' => true],
                ['day' => 21, 'current' => true],
                ['day' => 22, 'current' => true],
                ['day' => 23, 'current' => true],
            ],
            [
                ['day' => 24, 'current' => true],
                ['day' => 25, 'current' => true],
                ['day' => 26, 'current' => true],
                ['day' => 27, 'current' => true],
                ['day' => 28, 'current' => true],
                ['day' => 29, 'current' => true],
                ['day' => 30, 'current' => true],
            ],
            [
                ['day' => 31, 'current' => true],
                ['day' => 1, 'current' => false],
                ['day' => 2, 'current' => false],
                ['day' => 3, 'current' => false],
                ['day' => 4, 'current' => false],
                ['day' => 5, 'current' => false],
                ['day' => 6, 'current' => false],
            ],
        ];

        $variantClasses = [
            'neutral' => 'border-stone-300 bg-stone-100 text-stone-700 dark:border-stone-700 dark:bg-stone-800 dark:text-stone-200',
            'primary' => 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-900 dark:bg-indigo-950 dark:text-indigo-300',
            'success' => 'border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-300',
            'warning' => 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-300',
            'danger' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-300',
        ];
    @endphp

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
                            August 2026
                        </h2>

                        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                            Project schedule and agency deadlines
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="rounded-sm border border-stone-300 p-2 text-stone-500 transition-colors hover:bg-stone-100 hover:text-stone-900 dark:border-stone-700 dark:text-stone-400 dark:hover:bg-stone-900 dark:hover:text-stone-100"
                            aria-label="Previous month"
                        >
                            <x-heroicon-o-chevron-left class="h-4 w-4" />
                        </button>

                        <button
                            type="button"
                            class="rounded-sm border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-200 dark:hover:bg-stone-900"
                        >
                            Today
                        </button>

                        <button
                            type="button"
                            class="rounded-sm border border-stone-300 p-2 text-stone-500 transition-colors hover:bg-stone-100 hover:text-stone-900 dark:border-stone-700 dark:text-stone-400 dark:hover:bg-stone-900 dark:hover:text-stone-100"
                            aria-label="Next month"
                        >
                            <x-heroicon-o-chevron-right class="h-4 w-4" />
                        </button>
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
                    @foreach ($weeks as $week)
                        @foreach ($week as $date)
                            @php
                                $dayEvents = collect($events)
                                    ->where('day', $date['day'])
                                    ->values();
                            @endphp

                            <div
                                @class([
                                    'min-h-32 border-b border-r border-stone-200 p-3 last:border-r-0 dark:border-stone-800',
                                    'bg-white dark:bg-stone-950' => $date['current'],
                                    'bg-stone-50 dark:bg-stone-900' => ! $date['current'],
                                ])
                            >
                                <div class="flex items-start justify-between">
                                    @if ($date['current'] && $date['day'] === 6)
                                        <span class="flex h-6 w-6 items-center justify-center rounded-sm bg-indigo-600 text-xs font-bold text-white">
                                            {{ $date['day'] }}
                                        </span>
                                    @else
                                        <span
                                            @class([
                                                'text-sm font-semibold',
                                                'text-stone-900 dark:text-stone-100' => $date['current'],
                                                'text-stone-400 dark:text-stone-600' => ! $date['current'],
                                            ])
                                        >
                                            {{ $date['day'] }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 space-y-2">
                                    @foreach ($dayEvents as $event)
                                        <div
                                            class="rounded-sm border px-2 py-1.5 text-xs font-semibold {{ $variantClasses[$event['variant']] }}"
                                        >
                                            <p class="truncate">
                                                {{ $event['title'] }}
                                            </p>

                                            <p class="mt-1 text-[10px] font-medium opacity-70">
                                                {{ $event['type'] }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </x-card>

            <div class="space-y-6">
                <x-card title="Upcoming">
                    <ul class="divide-y divide-stone-200 dark:divide-stone-800">
                        <li class="flex gap-4 py-4 first:pt-0">
                            <div class="w-12 shrink-0 text-center">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Aug
                                </p>

                                <p class="mt-1 text-xl font-bold text-stone-900 dark:text-stone-100">
                                    6
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-stone-900 dark:text-stone-100">
                                    Homepage wireframes due
                                </p>

                                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                    Acme Outdoor Supply
                                </p>

                                <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">
                                    Today
                                </p>
                            </div>
                        </li>

                        <li class="flex gap-4 py-4">
                            <div class="w-12 shrink-0 text-center">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Aug
                                </p>

                                <p class="mt-1 text-xl font-bold text-stone-900 dark:text-stone-100">
                                    8
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-stone-900 dark:text-stone-100">
                                    Client review meeting
                                </p>

                                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                    Northstar Financial Group
                                </p>

                                <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">
                                    10:30 AM
                                </p>
                            </div>
                        </li>

                        <li class="flex gap-4 py-4">
                            <div class="w-12 shrink-0 text-center">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Aug
                                </p>

                                <p class="mt-1 text-xl font-bold text-stone-900 dark:text-stone-100">
                                    12
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-stone-900 dark:text-stone-100">
                                    Homepage Approved
                                </p>

                                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                    Acme Outdoor Supply
                                </p>

                                <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">
                                    In 6 days
                                </p>
                            </div>
                        </li>

                        <li class="flex gap-4 py-4 last:pb-0">
                            <div class="w-12 shrink-0 text-center">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Aug
                                </p>

                                <p class="mt-1 text-xl font-bold text-stone-900 dark:text-stone-100">
                                    14
                                </p>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-stone-900 dark:text-stone-100">
                                    Content Delivery
                                </p>

                                <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                    GreenLeaf Co.
                                </p>

                                <p class="mt-2 text-xs text-stone-500 dark:text-stone-400">
                                    In 8 days
                                </p>
                            </div>
                        </li>
                    </ul>
                </x-card>

                <x-card title="Calendar Key">
                    <div class="space-y-3">
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
                                Meeting
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