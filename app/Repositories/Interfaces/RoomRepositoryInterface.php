<?php
namespace App\Repositories\Interfaces;


interface RoomRepositoryInterface extends RepositoryInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isRoomBorrow($id);


}
