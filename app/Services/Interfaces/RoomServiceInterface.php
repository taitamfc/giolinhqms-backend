<?php
namespace App\Services\Interfaces;

interface RoomServiceInterface extends ServiceInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isRoomBorrow($id);

}

