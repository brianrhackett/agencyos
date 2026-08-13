<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Enums\ProjectStatus;
use App\Services\StatsService;
use App\Services\ActivityLogger;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;

class ProjectController extends Controller
{
    public function index(StatsService $stats)
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

       

        $projects = $this->_getProjectsData();

        $clientsWithActiveProjects = $this->_getClientsWithActiveProjects();

        return view('projects.index', [
			'summaryCards' => $summaryCards,
            'projects' => $projects,
            'activeProjectCount' => $summaryCards['activeProjects']['value'],
            'clientsWithActiveProjects' => $clientsWithActiveProjects
        ]);
    }

    public function create()
	{
		$clients = Client::orderBy('name')->get();
        $projectManagers = User::agency()
            ->orderBy('name')
            ->get();

        return view('projects.create', compact(
            'clients',
            'projectManagers'
        ));
	}

    public function store(Request $request)
	{
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'project_manager_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'priority' => ['required', 'in:low,medium,high'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $project = Project::create($validated);

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
		$clients = Client::orderBy('name')->get();
        $projectManagers = User::agency()
            ->orderBy('name')
            ->get();

        return view('projects.edit', compact(
            'project',
            'clients',
            'projectManagers'
        ));
	}

	public function update(Request $request, Project $project)
	{
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'project_manager_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(ProjectStatus::class)],
            'priority' => ['required', 'in:low,medium,high'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

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

    private function _getProjectsData()
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
            })->count();
    }

}
