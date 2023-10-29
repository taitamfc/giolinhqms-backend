<?php
namespace App\Services\Interfaces;
/*
ServiceInterface nằm cùng cấp, ko cần use
*/
interface DeviceServiceInterface extends ServiceInterface{
    public function trash($limit,$request);
    public function restore($id);
    public function forceDelete($id);
    public function updateQuantity($deviceId, $quantityChange);
}