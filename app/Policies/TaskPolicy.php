<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::TasksView);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        if(!$user->hasPermission(Permission::TasksView)) {
            return false;
        }

        return $user->agencyUser 
            || $user->belongsToClient($task->project->client_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::TasksCreate);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        if ($task->assigned_to === $user->id) {
            return true;
        }

        if(!$user->hasPermission(Permission::TasksUpdate)) {
            return false;
        }

        return $user->agencyUser 
            || $user->belongsToClient($task->project->client_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if(!$user->hasPermission(Permission::TasksDelete)) {
            return false;
        }

        return $user->agencyUser 
            || $user->belongsToClient($task->project->client_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
