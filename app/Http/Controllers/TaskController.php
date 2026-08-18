<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use App\Services\ActivityLogger;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;

class TaskController extends Controller
{
    public function index(StatsService $stats, Request $request)
	{
        $summaryCards = [
            [
                "title" => 'Open Tasks',
                "value" => $stats->openTasks()
            ],
            [
                "title" => 'Due Today',
                "value" => $stats->tasksDueToday()
            ],
            [
                "title" => 'Overdue',
                "value" => $stats->overdueTasks()
            ],
            [
                "title" => 'Completed This Week',
                "value" => $stats->tasksCompletedTthisWeek()
            ]
        ];

        $tasks = $this->_getTasksData($request);

        return view('tasks.index', [
			'summaryCards' => $summaryCards,
            'tasks' => $tasks,
            'totalTaskCount' => $stats->totalTasks(),
            'totalProjectWithTasksCount' => $stats->totalProjectWithTasks(),
            'statuses' => TaskStatus::cases(),
            'priorities' => TaskPriority::cases(),
            'assignees' => $this->_getPossibleAssignees(),
        ]);
    }

    public function board(Request $request)
    {
        $query = Task::with([
            'project',
            'assignedTo',
        ]);

        $user = auth()->user();

        if (!$user->agencyUser) {
            $clientIds = auth()->user()
                ->clients()
                ->pluck('clients.id');

            $query->whereHas('project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });
        } elseif (!$user->canViewAllProjects()) {
            $query->whereHas('project.teamMembers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        }

        $tasks = $query
            ->orderBy('due_date')
            ->get()
            ->groupBy(fn ($task) => $task->status->value);

        return view('tasks.board', compact('tasks'));
    }

    public function createForProject(Project $project)
	{
        $this->authorize('create', Task::class);
        
		$assignees = $project->teamMembers()
            ->orderBy('name')
            ->get();

		return view('tasks.create', [
			'project' => $project,
			'milestone' => null,
			'assignees' => $assignees,
		]);
	}

    public function createForMilestone(Milestone $milestone)
	{
        $this->authorize('create', Task::class);

		$milestone->load('project');

        $assignees = $milestone->project
            ->teamMembers()
            ->orderBy('name')
            ->get();

		return view('tasks.create', [
			'project' => $milestone->project,
			'milestone' => $milestone,
			'assignees' => $assignees,
		]);
	}

    public function storeForProject(Request $request, Project $project)
    {
        $this->authorize('create', Task::class);

        $validated = $this->_validateTask($request);

        $validated['project_id'] = $project->id;
        $validated['milestone_id'] = null;
        $validated['created_by'] = auth()->id();

        if ($validated['status'] === TaskStatus::Completed->value) {
            $validated['completed_at'] = now();
        }

        $task = Task::create($validated);

        ActivityLogger::log(
            'task.created',
            $task,
            [
                'task_name' => $task->title,
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

        return redirect($validated['return_to'] ?? route('projects.show', $project))
            ->with('success', 'Task created successfully.');
    }

    public function storeForMilestone(Request $request, Milestone $milestone)
    {
        $this->authorize('create', Task::class);

        $validated = $this->_validateTask($request);

        $validated['project_id'] = $milestone->project_id;
        $validated['milestone_id'] = $milestone->id;
        $validated['created_by'] = auth()->id();

        if ($validated['status'] === TaskStatus::Completed->value) {
            $validated['completed_at'] = now();
        }

        $task = Task::create($validated);

        ActivityLogger::log(
            'task.created',
            $task,
            [
                'task_name' => $task->title,
                'project_name' => $task->project->name,
                'milestone_name' => $milestone->name,
                'client_name' => $task->client->name,
            ]
        );

        return redirect(validated['return_to'] ?? route('milestones.show', $milestone))
            ->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $this->_validateTask($request);

        if (
            $validated['status'] === TaskStatus::Completed->value
            && !$task->completed_at
        ) {
            $validated['completed_at'] = now();

            $task_type = "task.completed";
        }
        else
        {
            $task_type = "task.updated";
        }

        if ($validated['status'] !== TaskStatus::Completed->value) {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        ActivityLogger::log(
            $task_type,
            $task,
            [
                'task_name' => $task->title,
                'project_name' => $task->project->name,
                'milestone_name' => $task->milestone?->name,
                'client_name' => $task->project->client->name,
            ]
        );

        return redirect($validated['return_to'] ?? route('tasks.show', $task))
            ->with('success', 'Task updated successfully.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $task->load('project');
        
        $projects = Project::where('completed_at', null)
            ->orderBy('name')
            ->get();
        
        $assignees = $task->project
            ->teamMembers()
            ->orderBy('name')
            ->get();

        return view('tasks.edit', compact(
            'task',
            'assignees',
            'projects'
        ));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load([
            'project.client',
            'milestone',
            'assignedTo',
            'createdBy',
            'comments.user',
            'files.uploader',
        ]);

        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        $this->authorize('create', Task::class);

        $projects = Project::with('milestones')
            ->orderBy('name')
            ->get();

        return view('tasks.create', [
            'projects' => $projects,
            'project' => null,
            'milestone' => null,
            'assignees' => collect(),
        ]);
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $validated = $this->_validateTask($request, true);

        $validated['created_by'] = auth()->id();

        if ($validated['status'] === TaskStatus::Completed->value) {
            $validated['completed_at'] = now();
        }

        $task = Task::create($validated);

        ActivityLogger::log(
            'task.created',
            $task,
            [
                'task_name' => $task->title,
                'project_name' => $task->project->name,
                'milestone_name' => $task->milestone?->name,
                'client_name' => $task->project->client->name,
            ]
        );

        return redirect( $validated['return_to'] ?? route('tasks.index') )
            ->with('success', 'Task created successfully.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        ActivityLogger::log(
            'task.deleted',
            $task,
            [
                'task_name' => $task->title,
                'project_name' => $task->project->name,
                'milestone_name' => $task->milestone?->name,
                'client_name' => $task->project->client->name,
            ]
        );

		return redirect()
			->route('tasks.index')
			->with('success', 'Task deleted successfully.');
    }

    private function _validateTask(Request $request, $includeContext = false): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'priority' => ['required', Rule::enum(TaskPriority::class)],
            'estimated_hours' => ['nullable', 'numeric', 'min:0'],
            'actual_hours' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'return_to' => ['nullable', 'url'],
        ];

        if ($includeContext) {
            $rules['project_id'] = ['required', 'exists:projects,id'];
            $rules['milestone_id'] = ['nullable', 'exists:milestones,id'];
        }

        return $request->validate($rules);
    }
    
    private function _getTasksData($request)
    {
        $query = Task::with([
            'project',
            'milestone',
            'assignedTo',
        ])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'ilike', "%{$search}%")
                    ->orWhereHas('project', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('project.client', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('milestone', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->priority, function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($request->assignee, function ($query, $assignee) {
                $query->where('assigned_to', $assignee);
            });


        $user = auth()->user();

        if ($user->isClientUser()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $query->whereHas('project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });
        } elseif (!$user->canViewAllProjects()) {
            $query->whereHas('project.teamMembers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });
        }

        return $query->paginate(5)
            ->withQueryString();
    }

    private function _getPossibleAssignees()
    {
        $user = auth()->user();

        if ($user->clients()->exists()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $assignees = User::where(function ($query) use ($clientIds) {
                $query->whereHas('clients', function ($query) use ($clientIds) {
                    $query->whereIn('clients.id', $clientIds);
                })
                ->orWhereDoesntHave('clients');
            })
            ->orderBy('name')
            ->get();
        } else {
            $assignees = User::orderBy('name')->get();
        }

        return $assignees;
    }
}
