<?php 
namespace App\Repositories\Interfaces;
//RepositoryInterface cùng cấp, ko cần use
interface BorrowRepositoryInterface extends RepositoryInterface{
    function trash($request);
    function restore($id);
    function forceDelete($id);
    public function updateBorrow($id, $data);
    
}