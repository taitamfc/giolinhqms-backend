<?php
namespace App\Services\Interfaces;
/*
ServiceInterface nằm cùng cấp, ko cần use
*/
interface BorrowDeviceServiceInterface extends ServiceInterface{
    public function trash();
    public function restore($id);
    public function forceDelete($id);

}