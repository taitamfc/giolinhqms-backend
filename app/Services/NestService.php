<?php

namespace App\Services;

use App\Repositories\Interfaces\NestRepositoryInterface;
use App\Services\Interfaces\NestServiceInterface;




class NestService implements NestServiceInterface {
    protected $nestRepository;
    public function __construct(NestRepositoryInterface $nestRepository)
    {
        return $this->nestRepository = $nestRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->nestRepository->paginate($limit,$request);
    }
    public function all($request=[])
    {
        return $this->nestRepository->all($request);
    }
    public function find($id)
    {
        return $this->nestRepository->find($id);
    }
    public function store($request)
    {
        return $this->nestRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->nestRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->nestRepository->destroy($id);
    }

    public function forceDelete($id)
    {
        return $this->nestRepository->forceDelete($id);
    }
    public function restore($id)
    {
        return $this->nestRepository->restore($id);
    }
    public function trash($request)
    {
        return $this->nestRepository->trash($request);
    }
    public function isUserNest($id)
    {
        return $this->nestRepository->isUserNest($id);
    }
}
