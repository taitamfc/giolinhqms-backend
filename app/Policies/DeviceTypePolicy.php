<?php

namespace App\Policies;

use App\Models\DeviceType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeviceTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('DeviceType_viewAny');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeviceType $deviceType)
    {
        return $user->hasPermission('DeviceType_view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('DeviceType_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeviceType $deviceType)
    {
        return $user->hasPermission('DeviceType_update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeviceType $deviceType)
    {
        return $user->hasPermission('DeviceType_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DeviceType $deviceType)
    {
        return $user->hasPermission('DeviceType_restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DeviceType $deviceType)
    {
        return $user->hasPermission('DeviceType_forceDelete');

    }
    public function trash(User $user)
    {
        return $user->hasPermission('DeviceType_trash');
    }
}
