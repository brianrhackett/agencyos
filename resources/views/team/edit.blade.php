<x-layouts.app>
    <x-layouts.app.content
        title="Edit Team Member"
        description="Update {{ $user->name }}'s details."
    >
        <form
            method="POST"
            action="{{ route('team.update', $user) }}"
            class="max-w-2xl space-y-6"
        >
            @csrf
            @method('PUT')

            @include('team._form')

            <div class="flex justify-end gap-3">
                <a
                    href="{{ route('team.show', $user) }}"
                    class="inline-flex items-center justify-center rounded-sm border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-800"
                >
                    Cancel
                </a>

                <x-button type="submit">
                    Save Changes
                </x-button>
            </div>
        </form>
    </x-layouts.app.content>
</x-layouts.app>