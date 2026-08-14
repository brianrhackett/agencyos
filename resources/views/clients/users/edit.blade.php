<x-layouts.app>
    <x-layouts.app.content
        title="Edit Client User"
        description="Update {{ $user->name }}."
    >
        <form
            method="POST"
            action="{{ route('clients.users.update', [$client, $user]) }}"
            class="max-w-2xl space-y-6"
        >
            @csrf
            @method('PUT')
            <x-card>
                @include('clients.users._form')

                <div class="mt-6 pt-6 px-6 -mx-6 border-t border-stone-200 dark:border-stone-800 flex gap-6">
                    <x-button type="submit">
                        Save Client User
                    </x-button>
                    <x-button 
                        href="{{ route('clients.show', $client) }}"
                        variant="ghost">
                        Cancel
                    </x-button>
                </div>
            </x-card>
        </form>
    </x-layouts.app.content>
</x-layouts.app>