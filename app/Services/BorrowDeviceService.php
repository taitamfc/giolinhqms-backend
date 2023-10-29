<?php

namespace App\Services;

use App\Services\Interfaces\BorrowDeviceServiceInterface;

use App\Repositories\Interfaces\BorrowDeviceRepositoryInterface;

class BorrowDeviceService implements BorrowDeviceServiceInterface
{
    protected $borrowdeviceRepository;

    public function __construct(BorrowDeviceRepositoryInterface $borrowdeviceRepository)
    {
        $this->borrowdeviceRepository = $borrowdeviceRepository;
    }

    /* Triển khai các phương thức trong BorrowServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->borrowdeviceRepository->paginate($limit,$request);
    }
    public function all($request=[]){
        return $this->borrowdeviceRepository->all($request);
    }
    public function find($id){
        return $this->borrowdeviceRepository->find($id);
    }
    public function store($request){
        return $this->borrowdeviceRepository->store($request);
    }
    public function update($request, $id){
        return $this->borrowdeviceRepository->update($request,$id);
    }
    public function destroy($id){
        return $this->borrowdeviceRepository->destroy($id);
    }
    public function trash(){
        return $this->borrowdeviceRepository->trash();
    }
    public function restore($id){
        return $this->borrowdeviceRepository->restore($id);
    }
    public function forceDelete($id){
        return $this->borrowdeviceRepository->forceDelete($id);
    }

    public function search($request=[]){
        return $this->borrowdeviceRepository->search($request);
    }
}