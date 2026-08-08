<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\StatsService;
use App\Models\Project;
use App\Models\Client;

class ProjectsController extends Controller
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

    private function _getProjectsData()
    {
        return Project::with([
            'client',
            'projectManager',
        ])
            ->withCount([
                'milestones',
                'tasks',
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'completed');
                },
                'tasks as open_tasks_count' => function ($query) {
                    $query->where('status', '!=', 'completed');
                },
            ])
            ->paginate(5)
            ->withQueryString();
    }

    private function _getClientsWithActiveProjects()
    {
        return Client::whereHas('projects', function ($query) {
                $query->where('status', 'active');
            })->count();
    }
}
