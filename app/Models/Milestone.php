<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Milestone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'status',
        'sort_order',
        'start_date',
        'due_date',
        'completed_at'
    ];

    public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class);
	}

	public function tasks(): HasMany
	{
		return $this->hasMany(Task::class);
	}

    public function activeTasks()
	{
		return $this->tasks()
			->whereNot('status', TaskStatus::Completed);
	}

	public function isOverdue(): bool
	{
		return $this->due_date?->isPast()
			&& $this->status !== MilestoneStatus::Completed;
	}

    public function progressPct(): float
	{
		$active_tasks = $this->activeTasks();
		$total_tasks = count($this->tasks());

		return round(100 * $active_tasks / $total_tasks, 2);
	}
}
