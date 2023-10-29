<?php

namespace App\Services;

use App\Services\Interfaces\DeviceServiceInterface;

use App\Repositories\Interfaces\DeviceRepositoryInterface;

class DeviceService implements DeviceServiceInterface
{
    protected $deviceRepository;

    public function __construct(DeviceRepositoryInterface $deviceRepository)
    {
        $this->deviceRepository = $deviceRepository;
    }
    public function updateQuantity($deviceId, $quantityChange)
    {
        return $this->deviceRepository->updateQuantity($deviceId, $quantityChange);
    }

    /* Triển khai các phương thức trong DeviceServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->deviceRepository->paginate($limit,$request);
    }
    public function all($request=[]){
        return $this->deviceRepository->all($request);
    }
    public function find($id){
        return $this->deviceRepository->find($id);
    }
    public function store($request){
        return $this->deviceRepository->store($request);
    }
    public function update($request, $id){
        return $this->deviceRepository->update($request,$id);
    }
    public function destroy($id){
        return $this->deviceRepository->destroy($id);
    }
    public function trash($limit,$request){
        return $this->deviceRepository->trash($limit,$request);
    }
    public function restore($id){
        return $this->deviceRepository->restore($id);
    }
    public function forceDelete($id){
        return $this->deviceRepository->forceDelete($id);
    }

    public function search($request=[]){
        return $this->deviceRepository->search($request);
    }


}