<?php 
namespace App\Repositories\Interfaces;
//RepositoryInterface cùng cấp, ko cần use
interface DeviceRepositoryInterface extends RepositoryInterface{
    function trash($limit,$request);
    function restore($id);
    function forceDelete($id);
}