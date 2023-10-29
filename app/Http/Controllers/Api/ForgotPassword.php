<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;


class ForgotPassword extends Controller
{
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function sendResetLinkEmail(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại.');
        }

        $forgot = $this->userService->forgotPassword($request);

        return response()->json($forgot, 200);
    }
}
