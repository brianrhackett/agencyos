<x-layouts.app>
    <x-layouts.app.content
        title="Add Team Member"
        description="Add a new member to your agency team."
    >
        <form
            method="POST"
            action="{{ route('team.store') }}"
            class="w-full space-y-6"
        >
            @csrf
            <x-card>
                @include('team._form')

                <div class="mt-6 pt-6 px-6 -mx-6 border-t border-stone-200 dark:border-stone-800 flex gap-6">
                    <x-button type="submit">
                        Add Team Member
                    </x-button>
                    <a
                        href="{{ route('team.index') }}"
                        class="inline-flex items-center justify-center rounded-sm border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-800"
                    >
                        Cancel
                    </a>
                </div>
            </x-card>
        </form>
    </x-layouts.app.content>
</x-layouts.app>