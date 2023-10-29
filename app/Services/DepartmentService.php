<?php

namespace App\Services;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\Interfaces\DepartmentServiceInterface;


class DepartmentService implements DepartmentServiceInterface {
    protected $departmentRepository;
    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        return $this->departmentRepository = $departmentRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->departmentRepository->paginate($limit,$request);
    }
    public function all($request=[])
    {
        return $this->departmentRepository->all($request);
    }
    public function find($id)
    {
        return $this->departmentRepository->find($id);
    }
    public function store($request)
    {
        return $this->departmentRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->departmentRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->departmentRepository->destroy($id);
    }

    public function forceDelete($id)
    {
        return $this->departmentRepository->forceDelete($id);
    }
    public function restore($id)
    {
        return $this->departmentRepository->restore($id);
    }
    public function trash($request)
    {
        return $this->departmentRepository->trash($request);
    }

    public function isDepartmentDevice($id){
        return $this->departmentRepository->isDepartmentDevice($id);
    }

    
}
