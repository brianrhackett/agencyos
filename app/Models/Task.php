<?php

namespace App\Models;

use App\Enums\Permission;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
		'project_id',
		'milestone_id',
		'assigned_to',
		'created_by',
		'title',
		'description',
		'status',
		'priority',
		'estimated_hours',
		'actual_hours',
		'start_date',
		'due_date',
		'completed_at',
    ];

    protected function casts(): array
	{
		return [
			'status' => TaskStatus::class,
			'priority' => TaskPriority::class,
			'estimated_hours' => 'decimal:2',
			'actual_hours' => 'decimal:2',
			'start_date' => 'date',
			'due_date' => 'date',
			'completed_at' => 'datetime',
		];
	}

    public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class);
	}

	public function milestone(): BelongsTo
	{
		return $this->belongsTo(Milestone::class);
	}

	public function assignedTo(): BelongsTo
	{
		return $this->belongsTo(User::class, 'assigned_to');
	}

	public function createdBy(): BelongsTo
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function files(): HasMany
	{
		return $this->hasMany(File::class);
	}

	public function isCompleted(): bool
	{
		return $this->status === TaskStatus::Completed;
	}

	public function isOverdue(): bool
	{
		return $this->due_date?->isPast()
			&& $this->status !== TaskStatus::Completed;
	}

	public function scopeVisibleTo($query, User $user)
	{
		// SuperAdmin / agency users with global project visibility.
		if ($user->canViewAllProjects()) {
			return $query;
		}
		
		if (! $user->hasPermission(Permission::TasksView)) {
			return $query->whereRaw('1 = 0');
		}

		return $query->whereHas('project', function ($query) use ($user) {
			$query->visibleTo($user);
		});
	}
}
