<?php
namespace App\Services\Interfaces;

interface DepartmentServiceInterface extends ServiceInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isDepartmentDevice($id);

}

