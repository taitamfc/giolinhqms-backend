<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoleRepository extends EloquentRepository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return Role::class;
    }
}
