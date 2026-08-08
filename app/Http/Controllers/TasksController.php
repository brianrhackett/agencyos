<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\StatsService;
use App\Models\Task;

class TasksController extends Controller
{
    public function index(StatsService $stats)
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

        $tasks = $this->_getTasksData();

        return view('tasks.index', [
			'summaryCards' => $summaryCards,
            'tasks' => $tasks,
            'totalTaskCount' => $stats->totalTasks(),
            'totalProjectWithTasksCount' => $stats->totalProjectWithTasks(),

        ]);
    }

    private function _getTasksData()
    {
        return Task::with([
            'project.client',
            'assignedTo'
        ])
            ->paginate(5)
            ->withQueryString();
    }
}
