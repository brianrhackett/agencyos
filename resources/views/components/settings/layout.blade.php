<div class="flex items-start max-md:flex-col p-8">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <nav class="space-y-1">
            <a
                href="{{ route('settings.profile') }}"
                wire:navigate
                @class([
                    'bg-transparent border-l-3 block rounded-none px-3 py-0 my-4 text-sm font-medium transition-colors hover:bg-transparent',
                    'border-indigo-600 bg-transparent text-indigo-700 dark:text-indigo-300'
                        => request()->routeIs('settings.profile'),
                    'border-transparent text-stone-600 hover:bg-stone-100 hover:text-stone-900 dark:text-stone-300 dark:hover:bg-stone-900 dark:hover:text-stone-100'
                        => ! request()->routeIs('settings.profile'),
                ])
            >
                Profile
            </a>

            <a
                href="{{ route('settings.password') }}"
                wire:navigate
                @class([
                    'bg-transparent border-l-3 block rounded-none  px-3 py-0 my-4 text-sm font-medium transition-colors hover:bg-transparent',
                    'border-indigo-600 bg-transparent text-indigo-700 dark:text-indigo-300'
                        => request()->routeIs('settings.password'),
                    'border-transparent text-stone-600 hover:bg-stone-100 hover:text-indigo-700 dark:text-stone-300 dark:hover:bg-stone-900 dark:hover:text-stone-100'
                        => ! request()->routeIs('settings.password'),
                ])
            >
                Password
            </a>

            <a
                href="{{ route('settings.appearance') }}"
                wire:navigate
                @class([
                    'bg-transparent border-l-3 block rounded-none px-3 py-0 my-4 text-sm font-medium transition-colors hover:bg-transparent',
                    'border-indigo-600 bg-transparent text-indigo-700 dark:text-indigo-300'
                        => request()->routeIs('settings.appearance'),
                    'border-transparent text-stone-600 hover:bg-stone-100 hover:text-indigo-700 dark:text-stone-300 dark:hover:bg-stone-900 dark:hover:text-stone-100'
                        => ! request()->routeIs('settings.appearance'),
                ])
            >
                Appearance
            </a>
        </nav>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
