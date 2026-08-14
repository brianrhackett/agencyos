<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Milestone;
use App\Models\File;

class StatsService
{
	public function totalClients(): int
	{
		return Client::count();
	}

	public function activeProjects(): int
	{
		$query = Project::where('status', 'active');
        
        $query = $this->_filterClientsProjectsQuery($query);
        
        return $query->count();
	}

    public function totalTasks(): int
    {
        return Task::count();
    }

    public function openTasks(): int
    {
        $query = Task::where('status', '!=', 'completed');

        $query = $this->_filterClientsTasksQuery($query);

		return $query->count();
    }

    public function overdueTasks(): int
    {
        $query = Task::whereDate('due_date', '<', today())
            ->where('status', '!=', 'completed');

        $query = $this->_filterClientsTasksQuery($query);

        return $query->count();
    }

	public function tasksDueToday(): int
	{
		$query = Task::whereDate('due_date', today())
			->where('status', '!=', 'completed');

        $query = $this->_filterClientsTasksQuery($query);
        
		return $query->count();
	}

    public function tasksDueTthisMonth(): int
	{
		$query = Task::whereBetween('due_date', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->where('status', '!=', 'completed');
        
        $query = $this->_filterClientsTasksQuery($query);
        
		return $query->count();
	}

    public function tasksCompletedTthisWeek(): int
	{
		$query = Task::whereBetween('completed_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->where('status', 'completed');

        $query = $this->_filterClientsTasksQuery($query);
        
		return $query->count();
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
		$query = Project::whereBetween('due_date', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->where('status', '!=', 'completed');
        
        $query = $this->_filterClientsProjectsQuery($query);
        
        return $query->count();
    }
    
    public function projectsCompletedThisQuarter(): int
    {
        $query = Project::where('status', 'completed')
            ->whereBetween('updated_at', [
                now()->startOfQuarter(),
                now()->endOfQuarter(),
            ]);

        $query = $this->_filterClientsProjectsQuery($query);
            
        return $query->count();
    }

    public function projectsNeedingAttention(): int
    {
        $query = Project::with(['client', 'tasks', 'milestones'])
                        ->where('status', 'active');

        $query = $this->_filterClientsProjectsQuery($query);

        $projects = $query->get();

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

    public function totalFiles()
    {
        $query = File::where('id','>',0);
        
        $query = $this->_filterClientsFilesQuery($query);

        return $query->count();
    }

    public function storageUsed()
    {
        $query = File::where('id','>',0);
        
        $query = $this->_filterClientsFilesQuery($query);

        return $query->sum('size');
    }

    public function uploadedThisWeek()
    {
        $query = File::where('created_at', '>=', now()->startOfWeek());

        $query = $this->_filterClientsFilesQuery($query);

        return $query->count();
    }

    public function sharedWithClients()
    {
        return File::where('is_client_visible', true)
	            ->count();
    }

    public function clientsWithFiles()
    {
        return Client::whereHas('projects.tasks.files')->count();
    }

    private function _filterClientsProjectsQuery($query)
    {
        $user = auth()->user();
        
        if($user->isClientUser()) {
            $query->whereIn(
                'client_id',
                $user->clients()->pluck('clients.id')
            );
        }

        return $query;
    }

    private function _filterClientsTasksQuery($query)
    {
        $user = auth()->user();

        if ($user->isClientUser()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $query->whereHas('project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });
        }

        return $query;
    }

    private function _filterClientsFilesQuery($query)
    {
        $user = auth()->user();
        
        if ($user->isClientUser()) {
            $clientIds = $user->clients()->pluck('clients.id');

            $query->whereHas('task.project', function ($query) use ($clientIds) {
                $query->whereIn('client_id', $clientIds);
            });

            $query->where('is_client_visible', true);
        }

        return $query;
    }
}