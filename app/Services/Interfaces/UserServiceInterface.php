<?php
namespace App\Services\Interfaces;

interface UserServiceInterface extends ServiceInterface {
    public function trash($request);
    public function forceDelete($id);
    public function restore($id);
    public function login();
    public function postLogin($request);
    public function logout();
    public function getInfoUser();
    public function forgotPassword($request);
    public function isUserBorrow($userId);
    public function history($id);
}
