<?php

namespace App\Services;

use App\Repositories\Interfaces\GroupRepositoryInterface;
use App\Services\Interfaces\GroupServiceInterface;




class GroupService implements GroupServiceInterface {
    protected $groupRepository;
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        return $this->groupRepository = $groupRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=[])
    {
        return $this->groupRepository->paginate($request);
    }
    public function all($request=[])
    {
        return $this->groupRepository->all($request);
    }
    public function find($id)
    {
        return $this->groupRepository->find($id);
    }
    public function store($request)
    {
        return $this->groupRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->groupRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->groupRepository->destroy($id);
    }
    public function forceDelete($id)
    {
        return $this->groupRepository->forceDelete($id);
    }
    public function restore($id)
    {
        return $this->groupRepository->restore($id);
    }
    public function getTrashed($request=[])
    {

    }
    public function isUserGroup($id)
    {
        return $this->groupRepository->isUserGroup($id);
    }
}
