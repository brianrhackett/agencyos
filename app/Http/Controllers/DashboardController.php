<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Milestone;
use App\Models\Activity;

class DashboardController extends Controller
{
	public function index(StatsService $stats)
	{
        $summaryCards = $this->_getSummaryCards($stats);
        $projectsNeedingAttention = $this->_getProjectsNeedingAttention();
        $upcomingMilestones = $this->_getUpcomingMilestones();
        $recentActivity = $this->_getRecentActivity();

        return view('dashboard', [
			'summaryCards' => $summaryCards,
            'projectsNeedingAttention' => $projectsNeedingAttention,
            'upcomingMilestones' => $upcomingMilestones,
            'recentActivity' => $recentActivity
		]);
	}

    private function _getSummaryCards(StatsService $stats)
    {
        return [
            [
                'title' => 'Total Clients',
                'value' => $stats->totalClients(),
            ],
            [
                'title' => 'Active Projects',
                'value' => $stats->activeProjects(),
            ],
            [
                'title' => 'Tasks Due Today',
                'value' => $stats->tasksDueToday(),
            ],
            [
                'title' => 'Awaiting Approval',
                'value' => $stats->tasksInReview(),
            ],
        ];
    }

    private function _getProjectsNeedingAttention()
    {
        $projects = Project::with(['client', 'tasks', 'milestones'])
                        ->where('status', 'active')
                        ->get();

        $needingAttention = $projects->map(function ($project) 
        {
            //overdue tasks check
            $overdueTasks = $project->tasks
                        ->where('status', '!=', 'completed')
                        ->filter(fn ($task) => $task->due_date < today());

            if ($overdueTasks->isNotEmpty()) {
                return [
                    'project_name' => $project->name,
                    'client_name' => $project->client->name,
                    'text_class' => 'text-red-600',
                    'attention_text' => $overdueTasks->count() . ' overdue tasks',
                    'sub_text' => ''
                ];
            }

            // approval check
		    $inReviewTasks = $project->tasks
                                ->where('status', 'in_review');
            
            if ($inReviewTasks->isNotEmpty()) {
                return [
                    'project_name' => $project->name,
                    'client_name' => $project->client->name,
                    'text-class' => 'text-orange-600',
                    'attention_text' => 'Client Approval Needed',
                    'sub_text' => ''
                ];
            }
            
            
            // milestone check
            $upcomingMilestone = $project->milestones
                ->filter(fn ($milestone) =>
                    $milestone->due_date >= today()
                    && $milestone->due_date <= today()->addDays(7)
                )
                ->sortBy('due_date')
                ->first();
            
            if (!empty($upcomingMilestone)) {
                return [
                    'project_name' => $project->name,
                    'client_name' => $project->client->name,
                    'text_class' => 'text-indigo-700',
                    'attention_text' => 'Milestone in ' . now()->diffInDays($upcomingMilestone->due_date) . ' day(s)',
                    'sub_text' => ''
                ];
            }
		    return null;
	    })
	    ->filter()
	    ->take(3);

        return $needingAttention;
    }

    private function _getUpcomingMilestones() : Collection
    {
        return Milestone::with(['project.client'])
            ->whereDate('due_date', '>=', today())
            ->whereHas('project', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('due_date')
            ->take(4)
            ->get();
    }

    private function _getRecentActivity(): Collection
    {
        $activities = Activity::with('user')
            ->latest()
            ->take(5)
            ->get();

        return $activities->map(function ($activity) {
            $metadata = $activity->metadata ?? [];

            $content = match ($activity->type) {
                'task_completed' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => ' completed the task ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['task_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' for ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['client_name'] . '.',
                        'bold' => true,
                    ],
                ],

                'files_uploaded' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => ' uploaded ' . $metadata['file_count'] . ' files to ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['project_name'] . '.',
                        'bold' => true,
                    ],
                ],

                'comment_added' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => ' left a comment on ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['task_name'] . '.',
                        'bold' => true,
                    ],
                ],

                'milestone_completed' => [
                    [
                        'text' => 'The milestone ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['milestone_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' was marked complete.',
                        'bold' => false,
                    ],
                ],

                'client_user_added' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => ' added ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['user_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' to ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['client_name'] . '.',
                        'bold' => true,
                    ],
                ],

                default => [
                    [
                        'text' => 'Activity recorded.',
                        'bold' => false,
                    ],
                ],
            };

            return [
                'type' => $activity->type,
                'content' => $content,
                'time' => $activity->created_at->diffForHumans(),
            ];
        });
    }
}