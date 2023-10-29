<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\RoleServiceInterface;




class RoleService implements RoleServiceInterface {
    protected $roleRepository;
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        return $this->roleRepository = $roleRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=[])
    {
        return $this->roleRepository->paginate($limit);
    }
    public function all($request=[])
    {
        return $this->roleRepository->all($request);
    }
    public function find($id)
    {
        return $this->roleRepository->find($id);
    }
    public function store($request)
    {
        return $this->roleRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->roleRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->roleRepository->destroy($id);
    }
}
