<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\MilestoneStatus;
use App\Enums\Permission;

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
		'completed_at',
    ];

	protected function casts(): array
	{
		return [
			'status' => MilestoneStatus::class,
			'start_date' => 'date',
			'due_date' => 'date',
			'completed_at' => 'datetime',
		];
	}

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

	public function scopeVisibleTo($query, User $user)
	{
		if (! $user->hasPermission(Permission::MilestonesView)) {
			return $query->whereRaw('1 = 0');
		}

		return $query->whereHas('project', function ($query) use ($user) {
			$query->visibleTo($user);
		});
	}
}
