<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function showLinkRequestForm()
    {
        return view('includes.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại.');
        }

        $this->userService->forgotPassword($request);

        return back()->with('success', 'Gửi yêu cầu thành công!');
    }
}
