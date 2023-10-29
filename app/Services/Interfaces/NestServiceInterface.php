<?php
namespace App\Services\Interfaces;

interface NestServiceInterface extends ServiceInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isUserNest($id);

}

