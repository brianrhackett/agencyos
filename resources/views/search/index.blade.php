@php
$linkClasses = 'text-sm font-bold block p-3 rounded-sm my-3 bg-stone-50 dark:bg-stone-900 flex items-center
                dark:text-stone-200 text-stone-800 hover:text-indigo-700 dark:hover:text-indigo-300 border-1 border-stone-100 dark:border-stone-800';
$spanClasses = 'block font-normal text-xs mt-2';
$pClasses = 'text-sm text-stone-500 dark:text-stone-400';
@endphp
<x-layouts.app>
    <x-layouts.app.content
        title="Search Results"
        description="Your AgencyOS search results."
    >
        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            @if ($search)
                @if(auth()->user()->isAgencyUser())
                    <x-card>
                        <h2 class="text-xl font-bold mb-4 text-stone-800 dark:text-stone-200">Clients</h2>
                        @forelse ($clients as $client)
                                <a class="{{ $linkClasses }}" href="{{ route('clients.show', $client) }}">
                                    <div>
                                        {{ $client->name }}
                                        <span class="{{ $spanClasses }}">{{ $client->primaryContact->first()->name }}</span>
                                    </div>
                                    <x-heroicon-o-chevron-right class="font-bold h-6 w-6 ml-auto h-6 w-6 shrink-0" />
                                </a>
                        @empty
                            <p class="{{ $pClasses }}">No clients found.</p>
                        @endforelse
                    </x-card>
                @endif
                <x-card>
                    <h2 class="text-xl font-bold mb-4 text-stone-800 dark:text-stone-200">Projects</h2>

                    @forelse ($projects as $project)
                        <a class="{{ $linkClasses }}" href="{{ route('projects.show', $project) }}">
                            <div>
                                {{ $project->name }}
                                <span class="{{ $spanClasses }}">{{ $project->client->name }}</span>
                            </div>
                            <x-heroicon-o-chevron-right class="font-bold h-6 w-6 ml-auto h-6 w-6 shrink-0" />
                        </a>
                    @empty
                        <p class="{{ $pClasses }}">No projects found.</p>
                    @endforelse
                </x-card>

                <x-card>

                    <h2 class="text-xl font-bold mb-4 text-stone-800 dark:text-stone-200">Milestones</h2>
                    @forelse ($milestones as $milestone)
                        <a class="{{ $linkClasses }}" href="{{ route('milestones.show', $milestone) }}">
                            <div>
                                {{ $milestone->name }}
                                <span class="{{ $spanClasses }}">{{ $milestone->project->name }}</span>
                            </div>
                            <x-heroicon-o-chevron-right class="font-bold h-6 w-6 ml-auto h-6 w-6 shrink-0" />
                        </a>
                    @empty
                        <p class="{{ $pClasses }}">No milestones found.</p>
                    @endforelse
                </x-card>

                <x-card>
                    <h2 class="text-xl font-bold mb-4 text-stone-800 dark:text-stone-200">Tasks</h2>

                    @forelse ($tasks as $task)
                        <a class="{{ $linkClasses }}" href="{{ route('tasks.show', $task) }}">
                            <div>
                                {{ $task->title }}
                                <span class="{{ $spanClasses }}">{{ $task->project->name }}</span>
                            </div>
                            <x-heroicon-o-chevron-right class="font-bold h-6 w-6 ml-auto h-6 w-6 shrink-0" />
                        </a>
                    @empty
                        <p class="{{ $pClasses }}">No tasks found.</p>
                    @endforelse
                </x-card>

                <x-card>
                    <h2 class="text-xl font-bold mb-4 text-stone-800 dark:text-stone-200">Files</h2>
                    @forelse ($files as $file)
                        <a class="{{ $linkClasses }}" href="{{ route('files.download', $file) }}">
                            <div>
                                {{ $file->original_name }}
                                <span class="{{ $spanClasses }}">{{ $file->task->title }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="{{ $pClasses }}">No files found.</p>
                    @endforelse
                </x-card>

                <x-card>
                    <h2 class="text-xl font-bold mb-4 text-stone-800 dark:text-stone-200">Users</h2>
                    @forelse ($users as $user)
                        <a class="{{ $linkClasses }}" href="{{ route('team.show', $user) }}">
                            <div>
                                {{ $user->name }}
                                <span class="{{ $spanClasses }}">{{ $user->currentClient() ?? $user->position ?? 'Agency User' }}</span>
                            </div>
                            <x-heroicon-o-chevron-right class="font-bold h-6 w-6 ml-auto h-6 w-6 shrink-0" />
                        </a>
                    @empty
                        <p class="{{ $pClasses }}">No users found.</p>
                    @endforelse
                </x-card>
            @else
                <h2>No results found.</h2>
            @endif
        </div>
    </x-layouts.app.content>
</x-layouts.app>