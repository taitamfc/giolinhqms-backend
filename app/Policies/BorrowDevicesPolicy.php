<?php

namespace App\Policies;

use App\Models\Borrow_devices;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BorrowDevicesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_view');
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_forceDelete');

    }
    public function trash(User $user): bool
    {
        return $user->hasPermission('BorrowDevice_trash');
    }
}
