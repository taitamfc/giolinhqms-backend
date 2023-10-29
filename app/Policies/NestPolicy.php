<?php

namespace App\Policies;

use App\Models\Nest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('Nest_viewAny');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Nest $nest)
    {
        return $user->hasPermission('view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('Nest_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->hasPermission('Nest_update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->hasPermission('Nest_delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        return $user->hasPermission('Nest_restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        return $user->hasPermission('Nest_forceDelete');
    }
    public function trash(User $user)
    {
        return $user->hasPermission('Nest_trash');
    }
}
