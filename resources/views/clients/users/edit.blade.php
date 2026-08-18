<x-layouts.app>
    <x-layouts.app.content
        title="Edit Client User"
        description="Update {{ $user->name }}."
    >
    
        <form
            method="POST"
            action="{{ route('clients.users.update', [$client, $user]) }}"
            class="w-full space-y-6"
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
                        href="{{ url()->previous() }}"
                        variant="ghost">
                        Cancel
                    </x-button>
                </div>
            </x-card>
        </form>

        <div class="my-6">
            <x-card
                title="Does this user need a password reset?"
            >
                <form
                    method="POST"
                    action="{{ route('team.password-reset', $user) }}"
                    class="mt-4"
                >
                    @csrf

                    <x-button type="submit" variant="primary">
                        Send Password Reset Link
                    </x-button>
                </form>
            </x-card>
        </div>
    </x-layouts.app.content>
</x-layouts.app>