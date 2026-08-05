<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Enums\ProjectStatus;
use App\Enums\ProjectPriority;

class Project extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'client_id',
		'project_manager_id',
		'name',
		'slug',
		'description',
		'status',
		'priority',
		'budget',
		'start_date',
		'due_date',
		'completed_at',
		'archived_at',
	];

	protected function casts(): array
	{
		return [
			'status' => ProjectStatus::class,
			'priority' => ProjectPriority::class,
			'budget' => 'decimal:2',
			'start_date' => 'date',
			'due_date' => 'date',
			'completed_at' => 'datetime',
			'archived_at' => 'datetime',
		];
	}

	public function client(): BelongsTo
	{
		return $this->belongsTo(Client::class);
	}

	public function projectManager(): BelongsTo
	{
		return $this->belongsTo(User::class, 'project_manager_id');
	}

	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class)
			->withPivot([
				'role',
				'can_view_financials',
			])
			->withTimestamps();
	}

	public function milestones(): HasMany
	{
		return $this->hasMany(Milestone::class)->orderBy('sort_order');
	}

	public function tasks(): HasMany
	{
		return $this->hasMany(Task::class);
	}

	public function activeMilestones()
	{
		return $this->Milestones()
			->whereNot('status', MilestoneStatus::Completed);
	}

	public function activeTasks()
	{
		return $this->tasks()
			->whereNot('status', TaskStatus::Completed);
	}

	public function isOverdue(): bool
	{
		return $this->due_date?->isPast()
			&& $this->status !== ProjectStatus::Completed;
	}

	public function progressPct(): float
	{
		$active_tasks = $this->activeTasks();
		$total_tasks = count($this->tasks());

		return round(100 * $active_tasks / $total_tasks, 2);
	}
}
