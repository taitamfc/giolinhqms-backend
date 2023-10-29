<?php
namespace App\Repositories\Interfaces;


interface GroupRepositoryInterface extends RepositoryInterface {
    public function isUserGroup($id);

}
