<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class OptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function update(User $user)
    {
        return $user->hasPermission('Option_update');
    }
}
