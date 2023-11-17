<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AssetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('Asset_viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Asset $asset)
    {
        return $user->hasPermission('Asset_view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('Asset_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Asset $asset)
    {
        return $user->hasPermission('Asset_update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Asset $asset)
    {
        return $user->hasPermission('Asset_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Asset $asset)
    {
        return $user->hasPermission('Asset_restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Asset $asset)
    {
        return $user->hasPermission('Asset_forceDelete');

    }
    public function trash(User $user)
    {
        return $user->hasPermission('Asset_trash');
    }
}