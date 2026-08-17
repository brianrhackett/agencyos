<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

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
                    'attention_text' => 'Milestone in ' . round(now()->diffInDays($upcomingMilestone->due_date),0) . ' day(s)',
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

            $typeParts = explode('.', $activity->type);

            $iconBgClasses = match ($typeParts[1]) {
                'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300',
                'deleted' => 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
                default => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300'
            };

            $icon = match ($typeParts[0]) {
                'task' => Blade::render('<x-heroicon-o-check-circle class="h-4 w-4" />'),
                'project' => Blade::render('<x-heroicon-o-folder class="h-4 w-4" />'), 
                'file' => Blade::render('<x-heroicon-o-document-plus class="h-4 w-4" />'),
                'milestone' => Blade::render('<x-heroicon-o-flag class="h-4 w-4" />'),
                'client_user' => Blade::render('<x-heroicon-o-user-plus class="h-4 w-4" />'),
                'team' => Blade::render('<x-heroicon-o-users class="h-4 w-4" />'),
                default => Blade::render('<x-heroicon-o-document class="h-4 w-4" />'),
            };

            $icon = match ($activity->type) {
                'task.commented' => Blade::render('<x-heroicon-o-chat-bubble-left-ellipsis class="h-4 w-4" />'),
                'file.deleted' =>  Blade::render('<x-heroicon-o-document-minus class="h-4 w-4" />'),
                default => $icon
            };

            $content = match ($typeParts[0]) {
                'task' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => $typeParts[1] == 'commented' ? ' commented on the task ' : $typeParts[1] . ' the task ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['task_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' in the project ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['project_name'],
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
                'project' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => $typeParts[1] . ' the project ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['project_name'],
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
                'file' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => $typeParts[1] == "deleted" ? ' deleted a file from the task '
                                                            : ' uploaded a file to the task ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['task_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' in the project ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['project_name'] . '.',
                        'bold' => true,
                    ],
                ],

                'milestone' => [
                    [
                        'text' => 'The milestone ',
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['milestone_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' has been ' . $typeParts[1] . '.',
                        'bold' => false,
                    ],
                ],

                'client_user' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => ' '. $typeParts[1] . ' ' ,
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['user_name'],
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

                'team' => [
                    [
                        'text' => $activity->user->name,
                        'bold' => true,
                    ],
                    [
                        'text' => ' '. $typeParts[1] . ' ' ,
                        'bold' => false,
                    ],
                    [
                        'text' => $metadata['user_name'],
                        'bold' => true,
                    ],
                    [
                        'text' => ' as a user.',
                        'bold' => false,
                    ]
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
                'iconBgClasses' => $iconBgClasses,
                'icon' => $icon,
                'content' => $content,
                'time' => $activity->created_at->diffForHumans(),
            ];
        });
    }
}