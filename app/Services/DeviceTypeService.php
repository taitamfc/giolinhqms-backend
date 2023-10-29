<?php

namespace App\Services;

use App\Repositories\Interfaces\DeviceTypeRepositoryInterface;
use App\Services\Interfaces\DeviceTypeServiceInterface;




class DeviceTypeService implements DeviceTypeServiceInterface {
    protected $deviceTypeRepository;
    public function __construct(DeviceTypeRepositoryInterface $deviceTypeRepository)
    {
        return $this->deviceTypeRepository = $deviceTypeRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->deviceTypeRepository->paginate($limit,$request);
    }
    public function all($request=[])
    {
        return $this->deviceTypeRepository->all($request);
    }
    public function find($id)
    {
        return $this->deviceTypeRepository->find($id);
    }
    public function store($request)
    {
        return $this->deviceTypeRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->deviceTypeRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->deviceTypeRepository->destroy($id);
    }

    public function forceDelete($id)
    {
        return $this->deviceTypeRepository->forceDelete($id);
    }
    public function restore($id)
    {
        return $this->deviceTypeRepository->restore($id);
    }
    public function trash($request)
    {
        return $this->deviceTypeRepository->trash($request);
    }
    public function isDevice_deviceType($id)
    {
        return $this->deviceTypeRepository->isDevice_deviceType($id);
    }
}
