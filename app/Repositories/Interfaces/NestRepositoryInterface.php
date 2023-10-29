<?php
namespace App\Repositories\Interfaces;


interface NestRepositoryInterface extends RepositoryInterface {
    public function forceDelete($id);
    public function restore($id);
    public function trash($request);
    public function isUserNest($id);

}
