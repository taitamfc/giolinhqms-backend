<?php
namespace App\Repositories\Interfaces;


interface DeviceTypeRepositoryInterface extends RepositoryInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isDevice_deviceType($id);

}
