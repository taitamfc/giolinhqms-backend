<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface;
use App\Http\Requests\LoginValidateRequest;





class AuthController extends Controller
{
    protected $userService;
    
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function login()
    {
        $checkUser = $this->userService->login();
        if ($checkUser) {
            return redirect()->route('users.index');
        } else {
            return view('includes.login');
        }
    }

    public function postLogin(LoginValidateRequest $request)
    {       
            $dataUser = $this->userService->postLogin($request);
            if ($dataUser) {
                return redirect()->route('users.index')->with('success', 'Đăng nhập thành công!');
            }else{
                return redirect()->route('login')->with('error', 'Tài khoản hoặc mật khẩu không đúng!');
            }
    }
    public function logout(Request $request)
    {
        $this->userService->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }

}
