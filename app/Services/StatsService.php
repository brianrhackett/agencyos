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

	public function tasksDueToday(): int
	{
		return Task::whereDate('due_date', today())
			->where('status', '!=', 'completed')
			->count();
	}

	public function tasksInReview(): int
	{
		return Task::where('status', 'in_review')->count();
	}

    public function activeClients(): int
    {
        return Client::where('is_active', true)->count();
    }

}