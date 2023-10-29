<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BorrowController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\Historycontroller;
use App\Http\Controllers\Api\NestController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\DeviceTypeController;
use App\Http\Controllers\Api\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*
Để sử dụng JWT
-chạy lệnh cài đặt và cấu hình
-Sau khi cài đặt thành công, bạn cần thêm JWTAuthServiceProvider và JWTAuth vào tệp config/app.php để sử dụng Facade và ServiceProvider.
-Chạy lệnh sau để tạo các khóa cần thiết cho JWT: php artisan jwt:secret
-Trong tệp config/auth.php, thêm cấu hình cho cơ chế xác thực guards để sử dụng JWT. Bạn có thể thêm một guard tên là api
-Trong model User, bạn cần thêm trait Tymon\JWTAuth\Contracts\JWTSubject và định nghĩa các phương thức getJWTIdentifier và getJWTCustomClaims
*/

//Middleware cần cấu hình ở config,tạo PreventBackHistory trong middleware

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function () {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/forgot_password', [App\Http\Controllers\Api\ForgotPassword::class, 'sendResetLinkEmail']);

});

Route::apiResource('users', UserController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('nests', NestController::class);
Route::apiResource('departments', DepartmentController::class);

Route::post('borrows/checkBorrow',[BorrowController::class,'checkBorrow']);
Route::apiResource('borrows',BorrowController::class);
Route::apiResource('rooms',RoomController::class);
Route::apiResource('device_types',DeviceTypeController::class);
// Device Api
Route::get('devices',[DeviceController::class,'getDevices']);
Route::get('device-calendar/{id}',[DeviceController::class,'getDeviceCalendar']);

// History api
Route::get('histories/{id}',[Historycontroller::class,'getHistories']);
// Departments

