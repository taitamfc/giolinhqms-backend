<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset as ModelsPasswordReset;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
// use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    public function login(Request $request)
    {
        //Kiểm tra dử liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        //dử liệu đầu vào có lổi -> trả về JSON và 422
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //xác thực người dùng nếu sai -> trả về 401 Unauthorized
        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        //thành công -> trả về một phản hồi chứa JSON
        return  response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'user' => auth('api')->user(), //THÔNG TIN VỀ USER ĐĂNG NHẬP
            'access_token' => $token, //tạo token
            'token_type' => 'bearer', //loại token
            'expires_in' => Config::get('jwt.ttl'), //thời gian tồn tại của token
        ]);
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['mesage' => 'Đăng xuất thành công']);
        //tesst postman thêm cặp khóa kêy = Authorization , value = Bearer token vào phần header
    }

    /*
    - ĐỂ CÓ THỂ TEST FORGOT BẰNG POSTMAN :
        FORGOT PASSWORD
        1. Cấu hình : Email Notification
        php artisan make:notification ResetPasswordNotification
        2. Tùy chỉnh  Model tạo ra để forgot
        3. Viết Route
        4. Viết logic xử lí Controller
        5. Test Postman
            +Test Forgot Password
                - thêm cặp khóa kêy = Authorization , value = Bearer token vào phần header
                - Chọn body và raw
                - Định dạng JSON
                    {
                        "email": "example@example.com"
                    }
            +Test Reset
                - thêm cặp khóa kêy = Authorization , value = Bearer    token vào phần header
                - Chọn body và raw
                - Định dạng JSON
                {
                    "token": "token tạo ra ở forgot",
                    "new_password": "new-password",
                    "confirm_password": "new-password"
                }
    */

    public function forgot_password(Request $request)
    {
        // tìm người dùng có địa chỉ email trùng với email được gửi trong yêu cầu.
        //firstOrFail() được sử dụng để trả về người dùng đầu tiên mà bạn tìm thấy với điều kiện, và nếu không tìm thấy, nó sẽ gây ra một ngoại lệ
        $user = User::where('email', $request->email)->firstOrFail();

        /*
        - Tạo mới or cập nhật
        - [] đầu tiên là điều kiện (trong trường hợp này là email)
        - [] thứ 2 chỉ định các giá trị sẻ được thêm mới or cập nhật (ở đây là token)
        */
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);

        //Nếu là passwordReset -> gửi thông báo đến email yêu cầu forgot chứa token được sử dụng để xác định user và đặt lại password
        if ($passwordReset) {
            $user->notify(new ResetPasswordRequest($passwordReset->token));
        }

        // Thành công
        return response()->json([
            'message' => 'Chúng tôi đã gửi email liên kết đặt lại mật khẩu của bạn!',
            'email' => $user->email,
        ]);
        // LƯU Ý : token thường được lưu trong bảng riêng biệt để quản lý quá trình đặt lại mật khẩu.
    }
    public function resetPassword(Request $request)
    {
        // Tìm người dùng dựa trên mã thông báo (token) được gửi trong yêu cầu đặt lại mật khẩu.
        $passwordReset = PasswordReset::where('token', $request->token)->first();

        // Không tìm thấy -> 422
        if (!$passwordReset) {
            return response()->json([
                'message' => 'Mã thông báo không hợp lệ.',
            ], 422);
        }

        // Tìm người dùng dựa trên email trong bảng PasswordReset
        $user = User::where('email', $passwordReset->email)->first();

        // Cập nhật trường password trong bản ghi người dùng với mật khẩu mới mà người dùng đã nhập
        $user->password = Hash::make($request->new_password);

        // Lưu thay đổi vào csdl
        $user->save();

        // Xóa giá trị của trường token trong bảng PasswordReset để nó không còn có giá trị nữa.
        $passwordReset->delete();


        // Thành công
        return response()->json([
            'message' => 'Mật khẩu đã được đặt lại thành công.',
        ]);
    }
}
