<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('Room_viewAny');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Room $room)
    {
        return $user->hasPermission('Room_view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasPermission('Room_create');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Room $room)
    {
        return $user->hasPermission('Room_update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Room $room)
    {
        return $user->hasPermission('Room_delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Room $room)
    {
        return $user->hasPermission('Room_restore');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Room $room)
    {
        return $user->hasPermission('Room_forceDelete');

    }
    public function trash(User $user): bool
    {
        return $user->hasPermission('Room_trash');
    }
}
