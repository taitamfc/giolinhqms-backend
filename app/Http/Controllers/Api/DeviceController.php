<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceCalendarResource;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use App\Models\BorrowDevice;
use Illuminate\Http\Request;
use App\Services\Interfaces\DeviceServiceInterface;

class DeviceController extends Controller
{
 
    protected $deviceService;
    public function __construct(DeviceServiceInterface $deviceService)
    {
        $this->deviceService = $deviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function getDevices(Request $request)
    {
        $items = $this->deviceService->all($request);
        //định dạng danh sách người dùng dưới dạng JSON
        return DeviceResource::collection($items);
    }

    public function getDeviceCalendar($id){
        $items = BorrowDevice::where('device_id', '=', $id )
        ->where('status', '=', 0)
        ->get();
        return DeviceCalendarResource::collection($items);
    }
}
