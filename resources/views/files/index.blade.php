<x-layouts.app>
    @php
        $files = [
            [
                'name' => 'homepage-wireframes-v3.pdf',
                'type' => 'PDF',
                'extension' => 'PDF',
                'size' => '4.8 MB',
                'project' => 'E-commerce Website Redesign',
                'client' => 'Acme Outdoor Supply',
                'uploaded_by' => 'Ethan Brooks',
                'initials' => 'EB',
                'uploaded_at' => '12 minutes ago',
                'icon' => 'document-text',
                'icon_classes' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
            ],
            [
                'name' => 'product-photography.zip',
                'type' => 'Archive',
                'extension' => 'ZIP',
                'size' => '186 MB',
                'project' => 'E-commerce Website Redesign',
                'client' => 'Acme Outdoor Supply',
                'uploaded_by' => 'Maya Rodriguez',
                'initials' => 'MR',
                'uploaded_at' => 'Yesterday',
                'icon' => 'archive-box',
                'icon_classes' => 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300',
            ],
            [
                'name' => 'northstar-brand-guidelines.pdf',
                'type' => 'PDF',
                'extension' => 'PDF',
                'size' => '12.4 MB',
                'project' => 'Digital Brand Refresh',
                'client' => 'Northstar Financial Group',
                'uploaded_by' => 'Nina Patel',
                'initials' => 'NP',
                'uploaded_at' => '2 days ago',
                'icon' => 'document-text',
                'icon_classes' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
            ],
            [
                'name' => 'dashboard-mockup.png',
                'type' => 'Image',
                'extension' => 'PNG',
                'size' => '2.1 MB',
                'project' => 'Customer Portal Build',
                'client' => 'Wave Industries',
                'uploaded_by' => 'Brian Hackett',
                'initials' => 'BH',
                'uploaded_at' => '4 days ago',
                'icon' => 'photo',
                'icon_classes' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300',
            ],
            [
                'name' => 'content-inventory.xlsx',
                'type' => 'Spreadsheet',
                'extension' => 'XLSX',
                'size' => '742 KB',
                'project' => 'Marketing Site Refresh',
                'client' => 'GreenLeaf Co.',
                'uploaded_by' => 'Nina Patel',
                'initials' => 'NP',
                'uploaded_at' => '6 days ago',
                'icon' => 'table-cells',
                'icon_classes' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
            ],
            [
                'name' => 'seo-audit-final.docx',
                'type' => 'Document',
                'extension' => 'DOCX',
                'size' => '1.3 MB',
                'project' => 'SEO Audit and Content Strategy',
                'client' => 'Northwind Studio',
                'uploaded_by' => 'Marcus Lee',
                'initials' => 'ML',
                'uploaded_at' => '1 week ago',
                'icon' => 'document',
                'icon_classes' => 'bg-sky-100 text-sky-700 dark:bg-sky-950 dark:text-sky-300',
            ],
        ];

        $recentFolders = [
            [
                'name' => 'Acme Outdoor Supply',
                'description' => '24 files across 3 projects',
            ],
            [
                'name' => 'Northstar Financial Group',
                'description' => '18 files across 2 projects',
            ],
            [
                'name' => 'Wave Industries',
                'description' => '31 files across 4 projects',
            ],
        ];
    @endphp

    <x-layouts.app.content
        title="Files"
        description="Browse, organize, and share files across clients and projects."
    >
        <x-slot:actions>
            <x-button>
                <x-heroicon-o-arrow-up-tray class="h-4 w-4" />

                Upload Files
            </x-button>
        </x-slot:actions>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Total Files
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    184
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Storage Used
                </p>

                <div class="mt-3 flex items-end justify-between gap-4">
                    <p class="text-3xl font-bold text-stone-900 dark:text-stone-100">
                        6.4 GB
                    </p>

                    <p class="text-xs font-medium text-stone-500 dark:text-stone-400">
                        of 20 GB
                    </p>
                </div>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Uploaded This Week
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    17
                </p>
            </x-card>

            <x-card>
                <p class="text-sm font-medium text-stone-500 dark:text-stone-400">
                    Shared With Clients
                </p>

                <p class="mt-3 text-3xl font-bold text-stone-900 dark:text-stone-100">
                    43
                </p>
            </x-card>
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
                            184 files across 24 clients
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
                            @foreach ($files as $file)
                                <tr class="transition-colors hover:bg-stone-50 dark:hover:bg-stone-900">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-sm {{ $file['icon_classes'] }}">
                                                @switch($file['icon'])
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
                                            {{ $file['project'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                            {{ $file['client'] }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-sm bg-stone-200 text-xs font-bold text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                                                {{ $file['initials'] }}
                                            </div>

                                            <span class="text-sm text-stone-700 dark:text-stone-300">
                                                {{ $file['uploaded_by'] }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-600 dark:text-stone-300">
                                        {{ $file['size'] }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-stone-500 dark:text-stone-400">
                                        {{ $file['uploaded_at'] }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <button
                                            type="button"
                                            class="rounded-sm p-2 text-stone-400 transition-colors hover:bg-stone-100 hover:text-stone-700 dark:hover:bg-stone-800 dark:hover:text-stone-200"
                                            aria-label="File actions"
                                        >
                                            <x-heroicon-o-ellipsis-horizontal class="h-5 w-5" />
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-4 border-t border-stone-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-stone-800">
                    <p class="text-sm text-stone-500 dark:text-stone-400">
                        Showing
                        <span class="font-semibold text-stone-700 dark:text-stone-200">1</span>
                        to
                        <span class="font-semibold text-stone-700 dark:text-stone-200">6</span>
                        of
                        <span class="font-semibold text-stone-700 dark:text-stone-200">184</span>
                        files
                    </p>

                    <div class="flex items-center gap-1">
                        <button
                            type="button"
                            disabled
                            class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-400 disabled:cursor-not-allowed disabled:opacity-50 dark:border-stone-700"
                        >
                            Previous
                        </button>

                        <button
                            type="button"
                            class="rounded-sm border border-indigo-600 bg-indigo-600 px-3 py-2 text-sm font-semibold text-white"
                        >
                            1
                        </button>

                        <button
                            type="button"
                            class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-600 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-900"
                        >
                            2
                        </button>

                        <button
                            type="button"
                            class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-600 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-900"
                        >
                            3
                        </button>

                        <button
                            type="button"
                            class="rounded-sm border border-stone-300 px-3 py-2 text-sm text-stone-600 transition-colors hover:bg-stone-100 dark:border-stone-700 dark:text-stone-300 dark:hover:bg-stone-900"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </x-card>

            <div class="space-y-6">
                <x-card title="Storage">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-2xl font-bold text-stone-900 dark:text-stone-100">
                                6.4 GB
                            </p>

                            <p class="mt-1 text-sm text-stone-500 dark:text-stone-400">
                                of 20 GB used
                            </p>
                        </div>

                        <p class="text-sm font-semibold text-stone-600 dark:text-stone-300">
                            32%
                        </p>
                    </div>

                    <div class="mt-4 h-2 overflow-hidden rounded-sm bg-stone-200 dark:bg-stone-800">
                        <div class="h-full w-[32%] bg-indigo-600"></div>
                    </div>

                    <div class="mt-6 space-y-3 border-t border-stone-200 pt-5 dark:border-stone-800">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-stone-500 dark:text-stone-400">
                                Documents
                            </span>

                            <span class="font-medium text-stone-700 dark:text-stone-300">
                                1.8 GB
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-stone-500 dark:text-stone-400">
                                Images
                            </span>

                            <span class="font-medium text-stone-700 dark:text-stone-300">
                                3.2 GB
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-stone-500 dark:text-stone-400">
                                Archives
                            </span>

                            <span class="font-medium text-stone-700 dark:text-stone-300">
                                1.4 GB
                            </span>
                        </div>
                    </div>
                </x-card>

                <x-card title="Client Folders">
                    <ul class="divide-y divide-stone-200 dark:divide-stone-800">
                        @foreach ($recentFolders as $folder)
                            <li class="flex items-center gap-3 py-4 first:pt-0 last:pb-0">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-sm bg-stone-100 text-stone-600 dark:bg-stone-800 dark:text-stone-300">
                                    <x-heroicon-o-folder class="h-5 w-5" />
                                </div>

                                <div class="min-w-0 flex-1">
                                    <a
                                        href="#"
                                        class="block truncate text-sm font-semibold text-stone-900 transition-colors hover:text-indigo-600 dark:text-stone-100 dark:hover:text-indigo-400"
                                    >
                                        {{ $folder['name'] }}
                                    </a>

                                    <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">
                                        {{ $folder['description'] }}
                                    </p>
                                </div>

                                <x-heroicon-o-chevron-right class="h-4 w-4 shrink-0 text-stone-400" />
                            </li>
                        @endforeach
                    </ul>
                </x-card>

                <x-card title="File Types">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-stone-600 dark:text-stone-300">
                                <span class="h-3 w-3 rounded-sm bg-red-500"></span>
                                PDF
                            </span>

                            <span class="font-semibold text-stone-700 dark:text-stone-200">
                                62
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-stone-600 dark:text-stone-300">
                                <span class="h-3 w-3 rounded-sm bg-indigo-500"></span>
                                Images
                            </span>

                            <span class="font-semibold text-stone-700 dark:text-stone-200">
                                48
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-stone-600 dark:text-stone-300">
                                <span class="h-3 w-3 rounded-sm bg-emerald-500"></span>
                                Spreadsheets
                            </span>

                            <span class="font-semibold text-stone-700 dark:text-stone-200">
                                19
                            </span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-stone-600 dark:text-stone-300">
                                <span class="h-3 w-3 rounded-sm bg-amber-500"></span>
                                Archives
                            </span>

                            <span class="font-semibold text-stone-700 dark:text-stone-200">
                                11
                            </span>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </x-layouts.app.content>
</x-layouts.app>