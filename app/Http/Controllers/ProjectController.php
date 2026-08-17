<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;
use App\Enums\ProjectRole;
use App\Services\StatsService;
use App\Services\ActivityLogger;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

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
        
        $agencyUsers = User::agency()
		    ->orderBy('name')
		    ->get();

        return view('projects.create', [
            'clients' => $clients,
            'agencyUsers' => $agencyUsers,
            'projectRoles' => ProjectRole::cases(),
        ]);
	}

    public function store(StoreProjectRequest $request)
	{        
        $this->authorize('create', Project::class);
        
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        
        $team = collect($validated['team'] ?? [])
	        ->filter(fn ($member) => !empty($member['role']));
            
        $leadUserId = $team
            ->filter(fn ($member) => $member['role'] === ProjectRole::Lead->value)
            ->keys()
            ->first();

        $validated['project_manager_id'] = $leadUserId;

        $project = Project::create($validated);

        $teamData = collect($validated['team'] ?? [])
            ->filter(fn ($member) => !empty($member['role']))
            ->mapWithKeys(function ($member, $userId) {
                return [
                    $userId => [
                        'role' => $member['role'],
                        'can_view_financials' => false,
                    ],
                ];
            })
            ->all();

        $project->teamMembers()->sync($teamData);

        ActivityLogger::log(
            'project.created',
            $project,
            [
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

        return redirect($validated['return_to'] ?? route('projects.index'))
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
            'directTasks.assignedTo',
            'teamMembers'
        ]);
        return view('projects.show', compact('project'));
	}

    public function board(Project $project)
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks()
            ->with(['assignedTo', 'milestone'])
            ->orderBy('due_date')
            ->get()
            ->groupBy(fn ($task) => $task->status->value);

        return view('projects.board', compact(
            'project',
            'tasks'
        ));
    }

    public function edit(Project $project)
	{
        $this->authorize('update', $project);

		$clients = Client::orderBy('name')->get();
        
        $project->load('teamMembers');
        
        $agencyUsers = User::agency()
		    ->orderBy('name')
		    ->get();

        $clientUsers = $project->client
            ->users()
            ->orderBy('name')
            ->get();

        return view('projects.edit', [
            'project' => $project,
            'clients' => $clients,
            'agencyUsers' => $agencyUsers,
            'clientUsers' => $clientUsers,
            'projectRoles' => ProjectRole::cases(),
        ]);
	}

	public function update(UpdateProjectRequest $request, Project $project)
	{
        $this->authorize('update', $project);

        $validated = $request->validated();

        $team = collect($validated['team'] ?? [])
            ->filter(fn ($member) => !empty($member['role']));

        $leadUserId = $team
            ->filter(fn ($member) => $member['role'] === ProjectRole::Lead->value)
            ->keys()
            ->first();

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
        $validated['project_manager_id'] = $leadUserId;
        $project->update($validated);

        $teamData = $team
            ->mapWithKeys(fn ($member, $userId) => [
                $userId => [
                    'role' => $member['role'],
                    'can_view_financials' => false,
                ],
            ])
            ->all();

        $project->teamMembers()->sync($teamData);

        ActivityLogger::log(
            $activityType,
            $project,
            [
                'project_name' => $project->name,
                'client_name' => $project->client->name,
            ]
        );

        return redirect($validated['return_to'] ?? route('projects.show', $project))
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
