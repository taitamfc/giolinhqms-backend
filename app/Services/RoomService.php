<?php

namespace App\Services;

use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Services\Interfaces\RoomServiceInterface;




class RoomService implements RoomServiceInterface {
    protected $roomRepository;
    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        return $this->roomRepository = $roomRepository;
    }
     /* Triển khai các phương thức trong GroupServiceInterface */
    public function paginate($limit,$request=null)
    {
        return $this->roomRepository->paginate($limit,$request);
    }
    public function all($request=[])
    {
        return $this->roomRepository->all($request);
    }
    public function find($id)
    {
        return $this->roomRepository->find($id);
    }
    public function store($request)
    {
        return $this->roomRepository->store($request);
    }
    public function update($request, $id)
    {
        return $this->roomRepository->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->roomRepository->destroy($id);
    }

    public function forceDelete($id)
    {
        return $this->roomRepository->forceDelete($id);
    }
    public function restore($id)
    {
        return $this->roomRepository->restore($id);
    }

    public function trash($request)
    {
        return $this->roomRepository->trash($request);
    }
    public function isRoomBorrow($id)
    {
        return $this->roomRepository->isRoomBorrow($id);
    }
}
