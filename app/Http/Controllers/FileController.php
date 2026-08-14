<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\StatsService;
use App\Services\ActivityLogger;

use App\Models\File;
use App\Models\Client;
use App\Models\Task;
use App\Models\Project;

class FileController extends Controller
{
    public function index(StatsService $stats, Request $request)
	{
        $storageUsed = $stats->storageUsed();
        
        $summaryCards = [
            'totalFiles' => [
                'title' => 'Total Files',
                'value' => $stats->totalFiles()
            ],
            'storageUsed' => [
                'title' => 'Storage Used',
                'value' => self::formatBytes($storageUsed)
            ],
            [
                'title' => 'Uploaded This Week',
                'value' => $stats->uploadedThisWeek()
            ],
            'sharedWithClientsCount' => [
                'title' => 'Shared With Clients',
                'value' => $stats->sharedWithClients()
            ]
        ];

        

        $files = $this->_getFilesData($request);
        

        $storageByType = collect($this->_getStorageByType())
                            ->map(fn ($bytes) => self::formatBytes($bytes));

        $clientFolders = $this->_getClientFolders();

        $fileTypeCounts = $this->_getFileTypeCounts();



        $totalStorageAvailable = 21474836480;
        $totalStoragePctUsed = round(100 * $storageUsed / $totalStorageAvailable, 0);

        $returnData = [
            'summaryCards' => $summaryCards,
            'files' => $files,
            'totalFiles' => $summaryCards['totalFiles']['value'],
            'clientsWithFiles' => $stats->clientsWithFiles(),
            'storageUsed' => $summaryCards['storageUsed']['value'],
            'totalStorageAvailable' => self::formatBytes($totalStorageAvailable),
            'totalStoragePctUsed' => $totalStoragePctUsed,
            'storageByType' => $storageByType,
            'clientFolders' => $clientFolders,
            'fileTypeCounts' => $fileTypeCounts,
            'projects' => $this->_getProjects(),
        ];

        $user = auth()->user();

        if( $user->isClientUser() )
        {
            unset($returnData['summaryCards']['sharedWithClientsCount']);
            unset($returnData['clientFolders']);
        }

        return view('files.index', $returnData);
    }

    public function store(Request $request, Task $task)
    {
        $this->authorize('view', $task);

		$validated = $request->validate([
			'file' => [
				'required',
				'file',
				'max:10240',
			],
		]);

		$uploadedFile = $validated['file'];

		$path = $uploadedFile->store(
			'tasks/' . $task->id,
			'public'
		);

		$task->files()->create([
			'uploaded_by' => auth()->id(),
			'name' => basename($path),
			'original_name' => $uploadedFile->getClientOriginalName(),
			'path' => $path,
			'mime_type' => $uploadedFile->getMimeType(),
			'size' => $uploadedFile->getSize(),
		]);

        ActivityLogger::log(
            'file.uploaded',
            $task,
            [
                'name' => $uploadedFile->getClientOriginalName(),
                'task_name' => $task->title,
                'project_name' => $task->project->name
            ]
        );

		return redirect()
			->route('tasks.show', $task)
			->with('success', 'File uploaded.');        
    }

    public function download(File $file)
    {
        $this->authorize('view', $file->task);

        if (!Storage::disk('public')->exists($file->path)) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $file->path,
            $file->name
        );
    }

    public function destroy(File $file)
    {
        $this->authorize('view', $file->task);
        
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        ActivityLogger::log(
            'file.deleted',
            $file,
            [
                'file_name' => $file->name,
                'task_name' => $file->task->title,
                'project_name' => $file->task->project->name
            ]
        );

        $file->delete();

        return back()->with('success', 'File deleted.');
    }

    private function _getFilesData($request)
    {
        $query = File::with('task.project','uploader',)
            ->when($request->search, function ($query, $search) {
                $query->where('original_name', 'ilike', "%{$search}%");
            })
            ->when($request->file_type, function ($query, $fileType) {
                switch ($fileType)
                {
                    case 'documents': 
                        $query->where('mime_type', 'application/pdf');
                        break;
                    case 'images': 
                        $query->where('mime_type', 'ilike', "image%");
                        break;
                    case 'spreadsheets': 
                        $query->whereIn('mime_type', ['application/vnd.ms-excel', 
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'text/csv'
                        ]);
                        break;
                    case 'archives': 
                        $query->whereIn('mime_type', ['application/zip',
                            'application/x-rar-compressed',
                            'application/x-7z-compressed',
                            'application/gzip'
                        ]);
                        break;
                }
            })
            ->when($request->project_id, function ($query, $projectId) {
                $query->whereHas('task', function ($query) use ($projectId) {
                    $query->where('project_id', $projectId);
                });
            });

        $user = auth()->user();
        
        if ($user->isClientUser()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $query->whereHas('task.project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });
            $query->where('is_client_visible', true);
        }

        
        return $query
            ->latest()
            ->paginate(6)
            ->withQueryString();
    }

    private function _getStorageByType()
    {
        $query = File::select('mime_type', 'size');

        $user = auth()->user();
        
        if ($user->isClientUser()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $query->whereHas('task.project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });

            $query->where('is_client_visible', true);
        }
         
        $files = $query->get();

        $storage = [
            'documents' => 0,
            'images' => 0,
            'archives' => 0,
            'spreadsheets' => 0
        ];

        foreach ($files as $file) {
            if (str_starts_with($file->mime_type, 'image/')) {
                $storage['images'] += $file->size;
                continue;
            }

            if (in_array($file->mime_type, [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv',
            ])) {
                $storage['spreadsheets'] += $file->size;
                continue;
            }

            if (in_array($file->mime_type, [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-7z-compressed',
                'application/gzip',
            ])) {
                $storage['archives'] += $file->size;
                continue;
            }

            $storage['documents'] += $file->size;
        }

        return $storage;
    }

    public static function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return round($bytes / 1073741824, 1) . ' GB';
        }

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }

    private function _getClientFolders()
    {
        return Client::whereHas('projects.tasks.files')
            ->withCount([
                'projects as projects_with_files_count' => function ($query) {
                    $query->whereHas('tasks.files');
                },
            ])
            ->get()
            ->map(function ($client) {
                $fileCount = File::whereHas('task.project', function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                })->count();

                return [
                    'name' => $client->name,
                    'file_count' => $fileCount,
                    'project_count' => $client->projects_with_files_count,
                ];
            })
            ->sortByDesc('file_count')
            ->take(3);
    }

    private function _getFileTypeCounts()
    {
        $query = File::select('mime_type');
        
        $user = auth()->user();
        
        if ($user->isClientUser()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $query->whereHas('task.project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });

            $query->where('is_client_visible', true);
        }

        $files = $query->get();

        $counts = [
            'pdf' => 0,
            'images' => 0,
            'spreadsheets' => 0,
            'archives' => 0,
        ];

        foreach ($files as $file) {
            if ($file->mime_type === 'application/pdf') {
                $counts['pdf']++;
                continue;
            }

            if (str_starts_with($file->mime_type, 'image/')) {
                $counts['images']++;
                continue;
            }

            if (in_array($file->mime_type, [
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/csv',
            ])) {
                $counts['spreadsheets']++;
                continue;
            }

            if (in_array($file->mime_type, [
                'application/zip',
                'application/x-rar-compressed',
                'application/x-7z-compressed',
                'application/gzip',
            ])) {
                $counts['archives']++;
            }
        }

        return [
            [
                'label' => 'PDF',
                'count' => $counts['pdf'],
                'colorClass' => 'bg-red-500'
            ],
            [
                'label' => 'Images',
                'count' => $counts['images'],
                'colorClass' => 'bg-indigo-500'
            ],
            [
                'label' => 'Spreadsheets',
                'count' => $counts['spreadsheets'],
                'colorClass' => 'bg-emerald-500'
            ],
            [
                'label' => 'Archives',
                'count' => $counts['archives'],
                'colorClass' => 'bg-amber-500'
            ],
        ];
    }

    private function _getProjects()
    {
        $user = auth()->user();

        $query = Project::with([
            'client',
            'projectManager',
        ]);

        if($user->isClientUser()) {
            $query->whereIn(
                'client_id',
                $user->clients()->pluck('clients.id')
            );
        }

        return $query->get();
    }
}
