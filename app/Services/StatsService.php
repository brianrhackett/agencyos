<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Milestone;

class StatsService
{
	public function totalClients(): int
	{
		return Client::count();
	}

	public function activeProjects(): int
	{
		return Project::where('status', 'active')->count();
	}

    public function totalTasks(): int
    {
        return Task::count();
    }

    public function openTasks(): int
    {
        return Task::where('status', '!=', 'completed')
			->count();
    }

    public function overdueTasks(): int
    {
        return Task::whereDate('due_date', '<', today())
            ->where('status', '!=', 'completed')
			->count();
    }

	public function tasksDueToday(): int
	{
		return Task::whereDate('due_date', today())
			->where('status', '!=', 'completed')
			->count();
	}

    public function tasksDueTthisMonth(): int
	{
		return Task::whereBetween('due_date', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->where('status', '!=', 'completed')
            ->count();
	}

    public function tasksCompletedTthisWeek(): int
	{
		return Task::whereBetween('completed_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->where('status', 'completed')
            ->count();
	}

	public function tasksInReview(): int
	{
		return Task::where('status', 'in_review')->count();
	}

    public function totalProjectWithTasks(): int
    {
        return Project::whereHas('tasks')->count();
    }

    public function activeClients(): int
    {
        return Client::where('is_active', true)->count();
    }

    public function projectsDueTthisMonth(): int
    {
		return Project::whereBetween('due_date', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->where('status', '!=', 'completed')
            ->count();
    }
    
    public function projectsCompletedThisQuarter(): int
    {
        return Project::where('status', 'completed')
            ->whereBetween('updated_at', [
                now()->startOfQuarter(),
                now()->endOfQuarter(),
            ])
            ->count();
    }

    public function projectsNeedingAttention(): int
    {
        $projects = Project::with(['client', 'tasks', 'milestones'])
                        ->where('status', 'active')
                        ->get();

        return $projects->map(function ($project) 
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
	    ->count();
    }
}