<x-layouts.app>
    <x-layouts.app.content
        title="Edit {{$project->name}}"
        description="Update project information."
    >

        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('PUT')
            <x-card>
                @include('projects._form', ['project' => $project])
                <div class="mt-6 pt-6 px-6 -mx-6 border-t border-stone-200 dark:border-stone-800 flex gap-6">
                    <x-button type="submit">
                        Save Changes
                    </x-button>
                    <x-button 
                        href="{{ route('projects.index') }}"
                        variant="ghost">
                        Cancel
                    </x-button>
                </div>
            </x-card>
        </form>
    </x-layouts.app.content>
</x-layouts.app>