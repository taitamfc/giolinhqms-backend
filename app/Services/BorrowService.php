<?php

namespace App\Services;

use App\Services\Interfaces\BorrowServiceInterface;

use App\Repositories\Interfaces\BorrowRepositoryInterface;

class BorrowService implements BorrowServiceInterface
{
    protected $borrowRepository;

    public function __construct(BorrowRepositoryInterface $borrowRepository)
    {
        $this->borrowRepository = $borrowRepository;
    }

    /* Triển khai các phương thức trong BorrowServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->borrowRepository->paginate($limit,$request);
    }
    public function all($request=[]){
        return $this->borrowRepository->all($request);
    }
    public function find($id){
        return $this->borrowRepository->find($id);
    }
    public function store($request){
        return $this->borrowRepository->store($request);
    }
    public function update($request, $id){
        return $this->borrowRepository->update($request,$id);
    }
    public function destroy($id){
        return $this->borrowRepository->destroy($id);
    }
    public function trash($request){
        return $this->borrowRepository->trash($request);
    }
    public function restore($id){
        return $this->borrowRepository->restore($id);
    }
    public function forceDelete($id){
        return $this->borrowRepository->forceDelete($id);
    }

    public function search($request=[]){
        return $this->borrowRepository->search($request);
    }
    public function updateBorrow($id, $data){
        return $this->borrowRepository->updateBorrow($id, $data);
    }
}