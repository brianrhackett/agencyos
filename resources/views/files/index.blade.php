<x-layouts.app>
    <x-layouts.app.content
        title="Files"
        description="Browse, organize, and share files across clients and projects."
    >
        <x-slot:actions>
            
        </x-slot:actions>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($summaryCards as $card)
                <x-card title="{{ $card['title'] }}">
                    <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                        {{ $card['value'] }}
                    </p>
                </x-card>
            @endforeach
        </div>

        <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_20rem]">
            <x-card
                :padding="false"
            >
                <div class="flex flex-col gap-4 border-b border-stone-200 px-6 py-5 3xl:flex-row 3xl:items-center 3xl:justify-between dark:border-stone-800">
                    <div>
                        <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                            All Files
                        </h2>

                        <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                            {{ $totalFiles }} files across {{ $clientsWithFiles }} clients
                        </p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative">
                            <x-heroicon-o-magnifying-glass
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400"
                            />

                            <input
                                type="search"
                                placeholder="Search files..."
                                class="w-full rounded-sm border border-stone-300 bg-white py-2 pl-9 pr-3 text-sm text-stone-900 outline-none transition-colors placeholder:text-stone-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 sm:w-64 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                            >
                        </div>

                        <select
                            class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                        >
                            <option>All file types</option>
                            <option>Documents</option>
                            <option>Images</option>
                            <option>Spreadsheets</option>
                            <option>Archives</option>
                        </select>

                        <select
                            class="rounded-sm border border-stone-300 bg-white px-3 py-2 text-sm text-stone-700 outline-none transition-colors focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/20"
                        >
                            <option>All projects</option>
                            <option>E-commerce Website Redesign</option>
                            <option>Digital Brand Refresh</option>
                            <option>Customer Portal Build</option>
                        </select>
                    </div>
                </div>

                <div class="w-full min-w-0 overflow-x-auto">
                    <table class="w-full min-w-[700px] divide-y divide-stone-200 dark:divide-stone-800">
                        <thead class="bg-stone-50 dark:bg-stone-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    File
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Project
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Uploaded By
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Size
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-stone-400">
                                    Uploaded
                                </th>

                                <th class="px-6 py-3 text-right">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-200 bg-white dark:divide-stone-800 dark:bg-stone-950">
                            @php
                                //die('<pre>'.print_r($files,1));
                            @endphp
                            @foreach ($files as $file)
                                <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm {{ $file->iconClasses() }}">
                                                @switch($file->icon())
                                                    @case('document-text')
                                                        <x-heroicon-o-document-text class="h-5 w-5" />
                                                        @break

                                                    @case('archive-box')
                                                        <x-heroicon-o-archive-box class="h-5 w-5" />
                                                        @break

                                                    @case('photo')
                                                        <x-heroicon-o-photo class="h-5 w-5" />
                                                        @break

                                                    @case('table-cells')
                                                        <x-heroicon-o-table-cells class="h-5 w-5" />
                                                        @break

                                                    @default
                                                        <x-heroicon-o-document class="h-5 w-5" />
                                                @endswitch
                                            </div>

                                            <div class="min-w-0">
                                                <a
                                                    href="#"
                                                    class="block max-w-64 truncate font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                                >
                                                    {{ $file['name'] }}
                                                </a>

                                                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                                    {{ $file['extension'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-stone-700 dark:text-stone-300">
                                            {{ $file->task->project->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            {{ $file->task->project->client->name }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-stone-700 dark:text-stone-300">
                                                {{ $file->uploader->name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                        {{ \App\Http\Controllers\FileController::formatBytes($file['size']) }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                        {{ $file['created_at']->diffForHumans() }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <div x-data="{ modalOpen: false }">
                                            <x-dropdown-menu>
                                                <x-dropdown-menu.item href="{{ route('files.download', $file) }}">
                                                    Download
                                                </x-dropdown-menu.item>

                                                <x-dropdown-menu.item
                                                    danger
                                                    @click="modalOpen = true"
                                                >
                                                    Delete
                                                </x-dropdown-menu.item>
                                            </x-dropdown-menu>
                                            <x-modal show="modalOpen" maxWidth="md">
                                                <div class="space-y-4">
                                                    <div class="px-6 py-4">
                                                        <h2 class="text-lg font-bold text-stone-900 dark:text-stone-100">
                                                            Delete File
                                                        </h2>

                                                        <p class="text-sm text-stone-600 dark:text-stone-400">
                                                            Are you sure you want to delete {{ $file->name }}?
                                                        </p>
                                                    </div>
                                                    <div class="flex justify-end gap-2 border-t border-stone-200 bg-stone-50 px-6 py-4 dark:border-stone-800 dark:bg-stone-900/50">
                                                        <div class="flex justify-end gap-3">
                                                            <x-button
                                                                type="button"
                                                                variant="secondary"
                                                                @click="modalOpen = false"
                                                            >
                                                                Cancel
                                                            </x-button>

                                                            <form
                                                                method="POST"
                                                                action="{{ route('files.destroy', $file) }}"
                                                            >
                                                                @csrf
                                                                @method('DELETE')

                                                                <x-button
                                                                    type="submit"
                                                                    variant="danger"
                                                                >
                                                                    Delete File
                                                                </x-button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </x-modal>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-4 border-t border-stone-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                    <p class="text-sm text-stone-500 dark:text-stone-400">
                        Showing
                        <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $files->firstItem() ?? 0 }}</span>
                        to
                        <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $files->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-stone-700 dark:text-stone-200">{{ $files->total() }}</span>
                        files
                    </p>

                    <div class="flex items-center gap-1">
                        {{ $files->links() }}
                    </div>
                </div>
            </x-card>

            <div class="space-y-6">
                <x-card title="Storage">
                    <div class="flex items-end justify-between gap-4 mt-4">
                        <div>
                            <p class="text-2xl font-bold text-stone-900 dark:text-stone-100">
                                {{ $storageUsed }}
                            </p>

                            <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                of {{ $totalStorageAvailable }} used
                            </p>
                        </div>

                        <p class="text-sm font-semibold text-stone-600 dark:text-stone-300">
                            {{ $totalStoragePctUsed }}%
                        </p>
                    </div>

                    <div class="mt-4 h-2 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                        <div 
                            class="h-full bg-indigo-600"
                            style="width:{{ $totalStoragePctUsed }}%;"
                        ></div>
                    </div>

                    <div class="mt-6 space-y-3 border-t border-stone-200 pt-5 dark:border-stone-800">
                        @foreach ($storageByType as $type => $size)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-stone-500 dark:text-stone-400">
                                    {{ ucfirst($type) }}
                                </span>
                                <span class="font-medium text-stone-700 dark:text-stone-300">
                                    {{ $size }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </x-card>

                @if (count($clientFolders))
                <x-card title="Client Folders">
                    <ul class="divide-y divide-stone-200 dark:divide-stone-800 mt-4">
                        @foreach ($clientFolders as $client)
                            <li class="flex items-center gap-3 py-4 first:pt-0 last:pb-0">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm bg-stone-100 text-stone-600 dark:bg-stone-800 dark:text-stone-300">
                                    <x-heroicon-o-folder class="h-5 w-5" />
                                </div>

                                <div class="min-w-0 flex-1">
                                    <a
                                        href="#"
                                        class="block truncate text-sm font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        {{ $client['name'] }}
                                    </a>

                                    <p class="text-sm text-stone-500">
                                        {{ $client['file_count'] }}
                                        {{ Str::plural('file', $client['file_count']) }}
                                        across
                                        {{ $client['project_count'] }}
                                        {{ Str::plural('project', $client['project_count']) }}
                                    </p>
                                </div>

                                <x-heroicon-o-chevron-right class="h-4 w-4 shrink-0 text-stone-400" />
                            </li>
                        @endforeach
                    </ul>
                </x-card>
                @endif

                <x-card title="File Types">
                    <div class="space-y-3 mt-4">
                        @foreach ($fileTypeCounts as $type => $count)
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center gap-2 text-stone-600 dark:text-stone-300">
                                    <span class="h-3 w-3 rounded-sm {{ $count['colorClass'] }}"></span>
                                    {{ $count['label'] }}
                                </span>

                                <span class="font-semibold text-stone-700 dark:text-stone-200">
                                    {{ $count['count'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            </div>
        </div>
    </x-layouts.app.content>
</x-layouts.app>