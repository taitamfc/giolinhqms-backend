<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Interfaces\DeviceServiceInterface;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\DeviceType;
use App\Models\BorrowDevice;
use App\Models\Department;
use App\Models\Device;

use App\Services\Interfaces\DeviceTypeServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

// use import & validate excel
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DeviceImport;
use App\Exports\DevicesExport;

use App\Http\Requests\ImportDeviceRequest;

class DeviceController extends Controller
{
    protected $deviceService;
    protected $deviceTypeService;

    public function __construct(DeviceServiceInterface $deviceService,DeviceTypeServiceInterface $deviceTypeService)
    {
        $this->deviceService = $deviceService;
        $this->deviceTypeService = $deviceTypeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Device::class);
        $items = $this->deviceService->paginate(20,$request);
        // $devicetypes = $this->deviceTypeService->all($request);
        $devicetypes = DeviceType::get();
        $departments = Department::get();
        return view('devices.index', compact('items','request','devicetypes','departments'));

    }
    public function create()
    {
        $this->authorize('create', Device::class);
        $devicetypes = DeviceType::get();
        $departments = Department::get();
        return view('devices.create',compact(['devicetypes','departments']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceRequest $request)
    {

        $data = $request->except(['_token', '_method']);
        $this->deviceService->store($data);
        return redirect()->route('devices.index')->with('success', 'Thêm thiết bị thành công');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->deviceService->find($id);
        $this->authorize('view', $item);
        return view('devices.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Device::find($id);
        $this->authorize('update', $item);
        $item = $this->deviceService->find($id);
        $devicetypes = DeviceType::get();
        $departments = Department::get();
        // dd($item);
        return view('devices.edit', compact('item','devicetypes','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceRequest $request, string $id)
    {
        // dd(123);
        $data = $request->except(['_token', '_method']);
        $this->deviceService->update($id, $data);
        return redirect()->route('devices.index')->with('success', 'Cập nhật thiết bị thành công');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Device::find($id);
        $this->authorize('delete', $item);
        try {
            // Lấy danh sách các device_id từ bảng borrow_devices
            $borrowedDeviceIds = BorrowDevice::pluck('device_id')->toArray();

            // Kiểm tra xem ID của thiết bị có trong danh sách borrow_devices hay không
            if (in_array($id, $borrowedDeviceIds)) {
                return redirect()->back()->with('error', 'Không thể xóa thiết bị vì đã có trong danh sách phiếu mượn!');
            }

            // Nếu không có liên kết, thực hiện việc xóa thiết bị
            $this->deviceService->destroy($id);
            return redirect()->route('devices.index')->with('success', 'Xóa thiết bị thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }


    public function trash(Request $request)
    {
        $this->authorize('trash', Device::class);
        $devicetypes = DeviceType::get();
        $items = $this->deviceService->trash(20,$request);
        return view('devices.trash', compact('items','devicetypes','request'));
    }
    public function restore($id)
    {
        $device = Device::find($id);
        $this->authorize('restore', $device);
        try {
            $this->deviceService->restore($id);
            return redirect()->route('devices.trash')->with('success', 'Khôi phục thiết bị thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('devices.trash')->with('error', 'Khôi phục không thành công!');
        }
    }
    public function forceDelete($id)
    {
        $device = Device::find($id);
        $this->authorize('forceDelete', $device);
        try {
            $this->deviceService->forceDelete($id);
            return redirect()->route('devices.trash')->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('devices.trash')->with('error', 'Xóa không thành công!');
        }
    }
    function getImport(){
        return view('devices.import');
    }
    public function import(ImportDeviceRequest $request) 
    {
        try {
            // Excel::import(new DeviceImport, request()->file('importData'));
            $import = new DeviceImport();
            Excel::import($import, request()->file('importData'));
            return redirect()->route('devices.getImport')->with('success', 'Thêm thành công');
        } catch (Exception $e) {
            return redirect()->route('devices.getImport')->with('error', 'Thêm thất bại');
        }
    }

    function export(){
        try {
            return Excel::download(new DevicesExport, 'devices.xlsx');
        } catch (Exception $e) {
            return redirect()->route('devices.index')->with('error', 'Xuất excel thất bại');
        }
    }
}