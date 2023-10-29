<?php

namespace App\Repositories\Eloquents;

use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;

class GroupRepository extends EloquentRepository implements GroupRepositoryInterface
{
    protected $roleRepository;
    public function getModel()
    {
        return Group::class;
    }
    public function __construct(RoleRepository $roleRepository) {
        parent::__construct();
        $this->roleRepository = $roleRepository;
    }

    public function all($request = null)
    {
        $query = $this->model->select('*');
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return $query->orderBy('id', 'DESC')->paginate(20);
    }

    public function update($id, $data)
    {
        return $this->find($id)->update($data);
    }
    public function isUserGroup($id) {
        return User::where('group_id', $id)->exists();
    }
}
