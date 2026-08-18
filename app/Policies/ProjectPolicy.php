<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
		return $user->hasPermission(Permission::ProjectsView);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        if(!$user->hasPermission(Permission::ProjectsView)) {
            return false;
        }
        
        // Client users can only see projects belonging to their client.
        if (!$user->agencyUser) {
            return $user->clients()
                ->where('clients.id', $project->client_id)
                ->exists();
        }

        // Higher-level agency users can see every project.
        if ($user->canViewAllProjects()) {
            return true;
        }

        // Everyone else must actually be assigned to the project.
        return $project->teamMembers()
            ->where('users.id', $user->id)
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::ProjectsCreate);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        if(!$user->hasPermission(Permission::ProjectsUpdate)) {
            return false;
        }

        return $user->agencyUser 
            || $user->belongsToClient($project->client_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        if(!$user->hasPermission(Permission::ProjectsDelete)) {
            return false;
        }

        return $user->agencyUser 
            || $user->belongsToClient($project->client_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }
}
