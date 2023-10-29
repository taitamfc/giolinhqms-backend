<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\DeviceTypeServiceInterface;
use Illuminate\Http\Request;

class DeviceTypeController extends Controller
{
    protected $devicetypeService;
    public function __construct(DeviceTypeServiceInterface $devicetypeService)
    {
        $this->devicetypeService = $devicetypeService;
    }
    public function index(Request $request)
    {
        $device_types = $this->devicetypeService->all($request);
        $devicetypeIds = $device_types->map(function ($device_type) {
            return [
                'id' => $device_type->id,
                'name' => $device_type->name,
            ];
        });
        return response()->json($devicetypeIds, 200);
    }
}
