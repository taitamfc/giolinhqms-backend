<?php
namespace App\Services\Interfaces;
/*
ServiceInterface nằm cùng cấp, ko cần use
*/
interface BorrowServiceInterface extends ServiceInterface{
    public function trash($request);
    public function restore($id);
    public function forceDelete($id);
    public function updateBorrow($id, $data);


}