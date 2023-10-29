<?php
namespace App\Repositories\Interfaces;


interface DepartmentRepositoryInterface extends RepositoryInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isDepartmentDevice($id);
}
