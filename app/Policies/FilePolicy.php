<?php

namespace App\Policies;

use App\Models\User;
use App\Models\File;

class FilePolicy
{
    public function view(User $user, File $file): bool
    {
        return $user->can('view', $file->task);
    }

    public function delete(User $user, File $file): bool
    {
        return $user->can('update', $file->task);
    }
}
