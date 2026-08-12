<x-layouts.app>
    <x-layouts.app.content
        title="Add Team Member"
        description="Add a new member to your agency team."
    >
        <form
            method="POST"
            action="{{ route('team.store') }}"
            class="max-w-2xl space-y-6"
        >
            @csrf

            @include('team._form')

            <div class="flex justify-end">
                <x-button type="submit">
                    Add Team Member
                </x-button>
            </div>
        </form>
    </x-layouts.app.content>
</x-layouts.app>