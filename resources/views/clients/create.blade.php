<x-layouts.app>
    <x-layouts.app.content
        title="Add Client"
        description="Add a new client to AgencyOS."
    >

        <form method="POST" action="{{ route('clients.store') }}">
            @csrf

            <x-card>
                @include('clients._form')

                <div class="mt-6 pt-6 px-6 -mx-6 border-t border-stone-200 dark:border-stone-800 flex gap-6">
                    <x-button type="submit">
                        <x-heroicon-o-plus class="h-4 w-4" />
                        Add Client
                    </x-button>
                    <x-button 
                        href="{{ route('clients.index') }}"
                        variant="ghost">
                        Cancel
                    </x-button>
                </div>
            </x-card>
        </form>
    </x-layouts.app.content>
</x-layouts.app>