<?php

namespace App\Policies;

use App\Models\Device;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DevicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('Device_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Device $device)
    {
        return $user->hasPermission('Device_view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('Device_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Device $device)
    {
        return $user->hasPermission('Device_update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Device $device)
    {
        return $user->hasPermission('Device_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Device $device)
    {
        return $user->hasPermission('Device_restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Device $device)
    {
        return $user->hasPermission('Device_forceDelete');

    }
    public function trash(User $user)
    {
        return $user->hasPermission('Device_trash');
    }
}
