<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;
use App\Services\StatsService;
use App\Services\ActivityLogger;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;

class ProjectController extends Controller
{
    public function index(StatsService $stats, Request $request)
	{
        $summaryCards = [
            'activeProjects' => [
                'title' => 'Active Projects',
                'value' => $stats->activeProjects()
            ],
            [
                'title' => 'Due This Month',
                'value' => $stats->projectsDueTthisMonth()
            ],
            [
                'title' => 'Needs Attention',
                'value' => $stats->projectsNeedingAttention()
            ],
            [
                'title' => 'Completed This Quarter',
                'value' => $stats->projectsCompletedThisQuarter()
            ]
        ];

       

        $projects = $this->_getProjectsData($request);

        $clientsWithActiveProjects = $this->_getClientsWithActiveProjects();

        return view('projects.index', [
			'summaryCards' => $summaryCards,
            'projects' => $projects,
            'activeProjectCount' => $summaryCards['activeProjects']['value'],
            'clientsWithActiveProjects' => $clientsWithActiveProjects,
            'clientsWithActiveProjectsCount' => $clientsWithActiveProjects->count(),
            'statuses' => ProjectStatus::cases(),
            'priorities' => ProjectPriority::cases(),
        ]);
    }

    public function create()
	{
        $this->authorize('create', Project::class);
        
		$clients = Client::orderBy('name')->get();
        
        $projectManagers = User::agency()
            ->orderBy('name')
            ->get();
        
        $teamMembers = User::agency()
		    ->orderBy('name')
		    ->get();

        return view('projects.create', compact(
            'clients',
            'projectManagers',
            'teamMembers'
        ));
	}

    public function store(Request $request)
	{        
        $this->authorize('create', Project::class);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'project_manager_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'priority' => ['required', Rule::enum(ProjectPriority::class)],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'team_members' => ['nullable', 'array'],
            'team_members.*' => ['exists:users,id'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $teamMembers = $validated['team_members'] ?? [];

        unset($validated['team_members']);

        $project = Project::create($validated);

        $project->teamMembers()->sync($teamMembers);

        ActivityLogger::log(
            'project.created',
            $project,
            [
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully.');
	}

	public function show(Project $project)
	{
        $this->authorize('view', $project);

        $project->load([
            'client',
            'projectManager',
            'milestones.tasks',
            'client',
            'projectManager',
            'directTasks.assignedTo',
            'milestones.tasks',
        ]);

        return view('projects.show', compact('project'));
	}

    public function edit(Project $project)
	{
        $this->authorize('update', $project);

		$clients = Client::orderBy('name')->get();
        
        $projectManagers = User::agency()
            ->orderBy('name')
            ->get();
        
        $teamMembers = User::agency()
		    ->orderBy('name')
		    ->get();

        return view('projects.edit', compact(
            'project',
            'clients',
            'projectManagers',
            'teamMembers'
        ));
	}

	public function update(Request $request, Project $project)
	{
        $this->authorize('update', $project);

        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'project_manager_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'priority' => ['required', Rule::enum(ProjectPriority::class)],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'team_members' => ['nullable', 'array'],
            'team_members.*' => ['exists:users,id'],
        ]);

        $teamMembers = $validated['team_members'] ?? [];

        unset($validated['team_members']);

        if (
            $validated['status'] === ProjectStatus::Completed->value
            && !$project->completed_at
        ) {
            $validated['completed_at'] = now();

            $activityType = "project.completed";
        }
        else
        {
            $activityType = "project.updated";
        }

        $validated['slug'] = Str::slug($validated['name']);

        $project->update($validated);

        $project->teamMembers()->sync($teamMembers);

        ActivityLogger::log(
            $activityType,
            $project,
            [
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully.');
	}

	public function destroy(Project $project)
	{
        $this->authorize('delete', $project);

        ActivityLogger::log(
            'project.deleted',
            $project,
            [
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );
        

        $project->delete();

		return redirect()
			->route('projects.index')
			->with('success', 'Project deleted successfully.');
	}

    private function _getProjectsData($request)
    {
        $user = auth()->user();
    
        $query = Project::with([
            'client',
            'projectManager',
        ])
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'ilike', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->priority, function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($request->client_id, function ($query, $clientId) {
                $query->where('client_id', $clientId);
            });

        if($user->isClientUser()) {
            $query->whereIn(
                'client_id',
                $user->clients()->pluck('clients.id')
            );
        }

        $query
            ->withCount([
                'milestones',
                'tasks',
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'completed');
                },
                'tasks as open_tasks_count' => function ($query) {
                    $query->where('status', '!=', 'completed');
                },
            ]);
            

        return $query->paginate(5)->withQueryString();
    }

    private function _getClientsWithActiveProjects()
    {
        return Client::whereHas('projects', function ($query) {
                $query->where('status', 'active');
            })->get();
    }

}
