<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\ClientUser;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientUserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClientUser $clientUser): bool
    {
        return $this->_canManage($user, $clientUser);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Client $client): bool
    {
        if (! $user->hasPermission(Permission::ClientUsersManage)) {
            return false;
        }

        if ($user->agencyUser) {
            return true;
        }

        return $user->clients()
            ->where('clients.id', $client->id)
            ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClientUser $clientUser): bool
    {
        return $this->_canManage($user, $clientUser);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClientUser $clientUser): bool
    {
        return $this->_canManage($user, $clientUser);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClientUser $clientUser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClientUser $clientUser): bool
    {
        return false;
    }

    private function _canManage(User $user, ClientUser $clientUser): bool
	{
		if (! $user->hasPermission(Permission::ClientUsersManage)) {
			return false;
		}

		if ($user->agencyUser) {
			return true;
		}

		return $user->clients()
			->where('clients.id', $clientUser->client_id)
			->exists();
	}
}
