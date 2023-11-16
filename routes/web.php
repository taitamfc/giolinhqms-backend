<?php
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('includes.login');
});

//Group
Route::prefix('groups')->group(function () {
    Route::get('/show/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::put('/saveRoles/{id}', [GroupController::class, 'saveRoles'])->name('groups.saveRoles');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('groups',\App\Http\Controllers\GroupController::class);
});

Route::get('/export-pdf/{id}', [\App\Http\Controllers\PDFController::class, 'exportPDF'])->name('export_PDF');


//User
Route::prefix('users')->group(function () {
    Route::get('/history/{id}', [UserController::class, 'history'])->name('users.borrow_history');
    Route::get('/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::get('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/force_destroy/{id}', [UserController::class, 'force_destroy'])->name('users.force_destroy');
    Route::get('/getImport', [UserController::class, 'getImport'])->name('users.getImport');
    Route::post('/import', [UserController::class, 'import'])->name('users.import');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users',\App\Http\Controllers\UserController::class);
});


//Device
Route::prefix('devices')->group(function () {
    Route::get('/getImport', [\App\Http\Controllers\DeviceController::class, 'getImport'])->name('devices.getImport');
    Route::post('/import', [\App\Http\Controllers\DeviceController::class, 'import'])->name('devices.import');
    Route::get('/trash', [\App\Http\Controllers\DeviceController::class, 'trash'])->name('devices.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\DeviceController::class, 'restore'])->name('devices.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\DeviceController::class, 'forceDelete'])->name('devices.forceDelete');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('devices',\App\Http\Controllers\DeviceController::class);
});

// Room
Route::prefix('rooms')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\RoomController::class, 'trash'])->name('rooms.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\RoomController::class, 'restore'])->name('rooms.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\RoomController::class, 'force_destroy'])->name('rooms.force_destroy');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('rooms',\App\Http\Controllers\RoomController::class);
});


// Login-Logout
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/checkLogin', [\App\Http\Controllers\AuthController::class, 'postLogin'])->name('checkLogin');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/forgot_password', [\App\Http\Controllers\AuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/post_forgot_password', [\App\Http\Controllers\AuthController::class, 'post_forgot_password'])->name('post_forgot_password');

//Forgot Password
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


// Borrow
Route::prefix('borrows')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\BorrowController::class, 'trash'])->name('borrows.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\BorrowController::class, 'restore'])->name('borrows.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\BorrowController::class, 'forceDelete'])->name('borrows.forceDelete');
    Route::get('/devices', [\App\Http\Controllers\BorrowController::class, 'devices'])->name('borrows.devices');
    Route::put('/{id}/updateBorrow', [\App\Http\Controllers\BorrowController::class, 'updateBorrow'])->name('borrows.updateBorrow');
});
Route::resource('borrows',\App\Http\Controllers\BorrowController::class);

//Export PDF
Route::get('/export-pdf/{id}', [\App\Http\Controllers\PDFController::class, 'exportPDF'])->name('export_PDF');
Route::get('/exportBook/{id}', [\App\Http\Controllers\ExportBookController::class, 'export'])->name('exportBook');
Route::get('/exportExcelBook/{id}', [\App\Http\Controllers\ExportUserHistoryBook::class, 'export_history_book'])->name('export_history_book');
Route::get('/exportExcelBorrow/{id}', [\App\Http\Controllers\ExportBorrow::class, 'export_borrow'])->name('export_borrow');

// BorrowDevice
Route::prefix('borrowdevices')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\BorrowDevicesController::class, 'trash'])->name('borrowdevices.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\BorrowDevicesController::class, 'restore'])->name('borrowdevices.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\BorrowDevicesController::class, 'forceDelete'])->name('borrowdevices.forceDelete');
    Route::get('/export-single-page', [\App\Http\Controllers\BorrowDevicesController::class, 'exportSinglePage'])->name('export.single.page');
    Route::get('/export-multi-page', [\App\Http\Controllers\BorrowDevicesController::class, 'exportMultiPage'])->name('export.multi.page');
});
Route::resource('borrowdevices',\App\Http\Controllers\BorrowDevicesController::class);
Route::get('test',[\App\Http\Controllers\BorrowDevicesController::class,'testHTML'])->name('borrowdevices.testHTML');

// ManageDevice
Route::prefix('managedevices')->group(function () {
    Route::get('/trash', [\App\Http\Controllers\ManageDeviceController::class, 'trash'])->name('managedevices.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\ManageDeviceController::class, 'restore'])->name('managedevices.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\ManageDeviceController::class, 'forceDelete'])->name('managedevices.forceDelete');
    //Route::get('/export-single-page', [\App\Http\Controllers\ManageDeviceController::class, 'exportSinglePage'])->name('export.single.page');
});
Route::resource('managedevices',\App\Http\Controllers\ManageDeviceController::class);
Route::get('test',[\App\Http\Controllers\ManageDeviceController::class,'testHTML'])->name('managedevices.testHTML');


// DeviceType
Route::prefix('devicetypes')->group(function () {
    Route::get('/getImport', [\App\Http\Controllers\DeviceTypeController::class, 'getImport'])->name('devicetypes.getImport');
    Route::post('/import', [\App\Http\Controllers\DeviceTypeController::class, 'import'])->name('devicetypes.import');
    Route::get('/trash', [\App\Http\Controllers\DeviceTypeController::class, 'trash'])->name('devicetypes.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\DeviceTypeController::class, 'restore'])->name('devicetypes.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\DeviceTypeController::class, 'forceDelete'])->name('devicetypes.forceDelete');
});
Route::resource('devicetypes',\App\Http\Controllers\DeviceTypeController::class);
// Thêm route sau vào web.php

// Nest
Route::prefix('nests')->group(function () {
    Route::get('/getImport', [\App\Http\Controllers\NestController::class, 'getImport'])->name('nests.getImport');
    Route::post('/import', [\App\Http\Controllers\NestController::class, 'import'])->name('nests.import');
    Route::get('/trash', [\App\Http\Controllers\NestController::class, 'trash'])->name('nests.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\NestController::class, 'restore'])->name('nests.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\NestController::class, 'forceDelete'])->name('nests.forceDelete');
});

Route::resource('nests',\App\Http\Controllers\NestController::class);

Route::prefix('options')->group(function () {
    Route::get('/', [\App\Http\Controllers\OptionController::class, 'index'])->name('options.index');
    Route::post('/options', [\App\Http\Controllers\OptionController::class, 'update'])->name('options.update'); 
});

// Departments
Route::prefix('departments')->group(function () {
    Route::get('/getImport', [\App\Http\Controllers\DepartmentController::class, 'getImport'])->name('departments.getImport');
    Route::post('/import', [\App\Http\Controllers\DepartmentController::class, 'import'])->name('departments.import');
    Route::get('/trash', [\App\Http\Controllers\DepartmentController::class, 'trash'])->name('departments.trash');
    Route::get('/restore/{id}', [\App\Http\Controllers\DepartmentController::class, 'restore'])->name('departments.restore');
    Route::delete('/force_destroy/{id}', [\App\Http\Controllers\DepartmentController::class, 'force_destroy'])->name('departments.force_destroy');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('departments',\App\Http\Controllers\DepartmentController::class);
});