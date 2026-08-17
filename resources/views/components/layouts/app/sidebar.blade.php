<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('partials.head')
	</head>

	<body class="min-h-screen bg-stone-50 text-stone-900 antialiased dark:bg-stone-900 dark:text-stone-100">
        <div class="min-h-screen lg:flex">
            <flux:sidebar
                sticky
                stashable
                class="h-screen w-72 border-r border-stone-200 bg-white dark:border-stone-800 dark:bg-stone-950"
            >
                <div class="flex h-full flex-col">
                    <div class="flex items-center border-b border-stone-200 py-2 dark:border-stone-800">
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center"
                            wire:navigate
                        >
                            <x-app-logo height="h-20" />
                        </a>

                        <flux:sidebar.toggle
                            class="ml-auto lg:hidden"
                            icon="x-mark"
                        />
                    </div>

                    <div class="flex flex-1 flex-col px-3 py-6">
                        <flux:navlist variant="outline">
                            <div class="mb-3 px-3 text-xs font-semibold uppercase tracking-widest text-stone-400">
	                            Workspace
                            </div>
                            <flux:navlist.group
                                heading=""
                                class="grid gap-1"
                            >
                                @if (auth()->user()->isAgencyUser())
                                    <flux:navlist.item
                                        icon="home"
                                        :href="route('dashboard')"
                                        :current="request()->routeIs('dashboard')"
                                        wire:navigate

                                        class="
                                            agency-nav-item
                                            rounded-none border-transparent
                                            data-current:!border-indigo-600
                                            data-current:!bg-transparent
                                            data-current:!text-indigo-600
                                            dark:data-current:!border-indigo-400
                                            dark:data-current:!bg-transparent
                                            dark:data-current:!text-indigo-300
                                        "
                                    >
                                        Dashboard
                                    </flux:navlist.item>

                                    <flux:navlist.item
                                        icon="building-office-2"
                                        :href="route('clients.index')"
                                        :current="request()->routeIs('clients.*')"
                                        wire:navigate
                                        class="
                                            agency-nav-item
                                            rounded-none border-transparent
                                            data-current:!border-indigo-600
                                            data-current:!bg-transparent
                                            data-current:!text-indigo-600
                                            dark:data-current:!border-indigo-400
                                            dark:data-current:!bg-transparent
                                            dark:data-current:!text-indigo-300
                                        "                                
                                    >
                                        Clients
                                    </flux:navlist.item>
                                @endif
                                
                                <flux:navlist.item
                                    icon="folder"
                                    :href="route('projects.index')"
                                    :current="request()->routeIs('projects.*')"
                                    wire:navigate
                                    class="
                                        agency-nav-item
                                        rounded-none border-transparent
                                        data-current:!border-indigo-600
                                        data-current:!bg-transparent
                                        data-current:!text-indigo-600
                                        dark:data-current:!border-indigo-400
                                        dark:data-current:!bg-transparent
                                        dark:data-current:!text-indigo-300
                                    "
                                >
                                    Projects
                                </flux:navlist.item>

                                <flux:navlist.item
                                    icon="check-circle"
                                    :href="route('tasks.index')"
                                    :current="request()->routeIs('tasks.*')"
                                    wire:navigate
                                    class="
                                        agency-nav-item
                                        rounded-none border-transparent
                                        data-current:!border-indigo-600
                                        data-current:!bg-transparent
                                        data-current:!text-indigo-600
                                        dark:data-current:!border-indigo-400
                                        dark:data-current:!bg-transparent
                                        dark:data-current:!text-indigo-300
                                    "
                                >
                                    Tasks
                                </flux:navlist.item>

                                <flux:navlist.item
                                    icon="calendar-days"
                                    :href="route('calendar.index')"
                                    :current="request()->routeIs('calendar.*')"
                                    wire:navigate
                                    class="
                                        agency-nav-item
                                        rounded-none border-transparent
                                        data-current:!border-indigo-600
                                        data-current:!bg-transparent
                                        data-current:!text-indigo-600
                                        dark:data-current:!border-indigo-400
                                        dark:data-current:!bg-transparent
                                        dark:data-current:!text-indigo-300
                                    "
                                >
                                    Calendar
                                </flux:navlist.item>
                            </flux:navlist.group>
                            <div class="mt-8 mb-3 px-3 text-xs font-semibold uppercase tracking-widest text-stone-400">
                                Resources
                            </div>
                            <flux:navlist.group
                                heading=""
                                class="grid gap-1"
                            >
                                <flux:navlist.item
                                    icon="users"
                                    :href="route('team.index')"
                                    :current="request()->routeIs('team.*')"
                                    wire:navigate
                                    class="
                                        agency-nav-item
                                        rounded-none border-transparent
                                        data-current:!border-indigo-600
                                        data-current:!bg-transparent
                                        data-current:!text-indigo-600
                                        dark:data-current:!border-indigo-400
                                        dark:data-current:!bg-transparent
                                        dark:data-current:!text-indigo-300
                                    "
                                >
                                    Team
                                </flux:navlist.item>

                                <flux:navlist.item
                                    icon="paper-clip"
                                    :href="route('files.index')"
                                    :current="request()->routeIs('files.*')"
                                    wire:navigate
                                    class="
                                        agency-nav-item
                                        rounded-none border-transparent
                                        data-current:!border-indigo-600
                                        data-current:!bg-transparent
                                        data-current:!text-indigo-600
                                        dark:data-current:!border-indigo-400
                                        dark:data-current:!bg-transparent
                                        dark:data-current:!text-indigo-300
                                    "
                                >
                                    Files
                                </flux:navlist.item>

                                <flux:navlist.item
                                    icon="cog-6-tooth"
                                    href="/settings/profile"
                                    :current="request()->routeIs('settings.*')"
                                    wire:navigate
                                    class="
                                        agency-nav-item
                                        rounded-none border-transparent
                                        data-current:!border-indigo-600
                                        data-current:!bg-transparent
                                        data-current:!text-indigo-600
                                        dark:data-current:!border-indigo-400
                                        dark:data-current:!bg-transparent
                                        dark:data-current:!text-indigo-300
                                    "
                                >
                                    Settings
                                </flux:navlist.item>
                            </flux:navlist.group>
                        </flux:navlist>

                        <flux:spacer />

                        <div class="border-t border-stone-200 pt-4 dark:border-stone-800">
                            <flux:dropdown
                                position="bottom"
                                align="start"
                            >
                                <button
                                    type="button"
                                    class="flex w-full items-center gap-3 rounded-sm px-3 py-2 text-left transition-colors hover:bg-stone-100 dark:hover:bg-stone-900"
                                >
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-stone-800 dark:text-indigo-300">
                                        {{ auth()->user()->initials() }}
                                    </span>

                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-stone-900 dark:text-stone-100">
                                            {{ auth()->user()->name }}
                                        </span>

                                        <span class="block truncate text-xs text-stone-500 dark:text-stone-400">
                                            {{ 
                                                auth()->user()->agencyUser?->job_title ?? 
                                                auth()->user()->clients->first()?->pivot->job_title 
                                            }}
                                        </span>
                                    </span>

                                    <x-heroicon-o-chevron-up-down class="h-4 w-4 text-stone-400" />
                                </button>

                                <flux:menu class="w-64">
                                    <div class="border-b border-stone-200 px-3 py-3 dark:border-stone-800">
                                        <p class="truncate text-sm font-semibold text-stone-900 dark:text-stone-100">
                                            {{ auth()->user()->name }}
                                        </p>

                                        <p class="mt-1 truncate text-xs text-stone-500 dark:text-stone-400">
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>

                                    <flux:menu.item
                                        href="/settings/profile"
                                        icon="cog-6-tooth"
                                        wire:navigate
                                    >
                                        Account settings
                                    </flux:menu.item>

                                    <flux:menu.separator />

                                    <form
                                        method="POST"
                                        action="{{ route('logout') }}"
                                        class="w-full"
                                    >
                                        @csrf

                                        <flux:menu.item
                                            as="button"
                                            type="submit"
                                            icon="arrow-right-start-on-rectangle"
                                            class="w-full"
                                        >
                                            Log out
                                        </flux:menu.item>
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </div>
                    </div>
                </div>
            </flux:sidebar>
            <div class="min-w-0 flex-1">
                <flux:header class="border-b border-stone-200 bg-white lg:hidden dark:border-stone-800 dark:bg-stone-950">
                    <flux:sidebar.toggle
                        icon="bars-2"
                        inset="left"
                    />

                    <a
                        href="{{ route('dashboard') }}"
                        class="ml-3"
                        wire:navigate
                    >
                        <x-app-logo height="h-7" />
                    </a>

                    <flux:spacer />

                    <flux:dropdown
                        position="top"
                        align="end"
                    >
                        <button
                            type="button"
                            class="flex h-9 w-9 items-center justify-center rounded-sm bg-indigo-100 text-sm font-bold text-indigo-700 dark:bg-stone-800 dark:text-indigo-300"
                        >
                            {{ auth()->user()->initials() }}
                        </button>

                        <flux:menu class="w-64">
                            <div class="border-b border-stone-200 px-3 py-3 dark:border-stone-800">
                                <p class="truncate text-sm font-semibold">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="mt-1 truncate text-xs text-stone-500 dark:text-stone-400">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>

                            <flux:menu.item
                                href="/settings/profile"
                                icon="cog-6-tooth"
                                wire:navigate
                            >
                                Account settings
                            </flux:menu.item>

                            <flux:menu.separator />

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                                class="w-full"
                            >
                                @csrf

                                <flux:menu.item
                                    as="button"
                                    type="submit"
                                    icon="arrow-right-start-on-rectangle"
                                    class="w-full"
                                >
                                    Log out
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </flux:header>

                <main class="min-h-screen bg-stone-50 dark:bg-stone-900">
                    {{ $slot }}
                </main>
            </div>
        </div>
		@fluxScripts
	</body>
</html>