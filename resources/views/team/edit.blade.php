<x-layouts.app>
    <x-layouts.app.content
        title="Edit Team Member"
        description="Update {{ $user->name }}'s details."
    >
        <form
            method="POST"
            action="{{ route('team.update', $user) }}"
            class="space-y-6 w-full"
        >
            @csrf
            @method('PUT')
            <x-card>
                @include('team._form')

                <div class="mt-6 pt-6 px-6 -mx-6 border-t border-stone-200 dark:border-stone-800 flex gap-6">
                    <x-button type="submit">
                        Save Changes
                    </x-button>

                    <a
                        href="{{ route('team.show', $user) }}"
                        class="inline-flex items-center justify-center rounded-sm border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-800"
                    >
                        Cancel
                    </a>
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