<?php

namespace App\Http\Controllers;

use App\Models\DeviceType;
use App\Http\Requests\StoreDeviceTypeRequest;
use App\Http\Requests\UpdateDeviceTypeRequest;
use App\Http\Requests\ImportDeviceTypesRequest;
use App\Services\Interfaces\DeviceTypeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DeviceTypeImport;
use App\Exports\DeviceTypeExport;

class DeviceTypeController extends Controller
{
    protected $deviceTypeService;
    public function __construct(DeviceTypeServiceInterface $deviceTypeService)
    {
        $this->deviceTypeService = $deviceTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
     
        $this->authorize('viewAny', DeviceType::class);
        $items = $this->deviceTypeService->all($request);
        return view('devicetypes.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', DeviceType::class);
        return view('devicetypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeviceTypeRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        $this->deviceTypeService->store($data);
        return redirect()->route('devicetypes.index')->with('success', 'Thêm mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceType $deviceType, $id)
    {
        $devicetype = DeviceType::find($id);
        $this->authorize('update', $devicetype);
        $devicetype = $this->deviceTypeService->find($id);
        return view('devicetypes.edit', compact('devicetype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceTypeRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $devicetype = $this->deviceTypeService->update($data, $id);
        return redirect()->route('devicetypes.index')->with('success', 'Cập Nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $devicetype = DeviceType::find($id);
        $this->authorize('delete', $devicetype);
        try {
            if ($this->deviceTypeService->isDevice_deviceType($id)) {
                return redirect()->back()->with('error', 'Trong loại thiết bị đang có thiết bị, không thể xóa!');
            }
            $this->deviceTypeService->destroy($id);
            return redirect()->route('devicetypes.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }
    public function trash(Request $request){
        $this->authorize('trash', DeviceType::class);
        $devicetypes = $this->deviceTypeService->trash($request);
        return view('devicetypes.trash',compact('devicetypes'));

    }

    public function restore($id){
        $devicetypes = DeviceType::find($id);
        $this->authorize('restore', $devicetypes);
        try {
            $room = $this->deviceTypeService->restore($id);
            return redirect()->route('devicetypes.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('devicetypes.trash')->with('error', 'Khôi phục không thành công!');
        }
    }

    public function force_destroy($id){
        $devicetype = DeviceType::find($id);
        $this->authorize('forceDelete', $devicetype);
        try {
            $room = $this->deviceTypeService->forceDelete($id);
            return redirect()->route('devicetypes.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('devicetypes.trash')->with('error', 'Xóa không thành công!');
        }
    }
    function getImport(){
        return view('devicetypes.import');
    }
    public function import(ImportDeviceTypesRequest $request) 
    {
        try {
            Excel::import(new DeviceTypeImport, request()->file('importData'));
            return redirect()->route('devicetypes.getImport')->with('success', 'Thêm thành công');
        } catch (Exception $e) {
            return redirect()->route('devicetypes.getImport')->with('error', 'Thêm thất bại');
        }
    }
    function export(){
        return Excel::download(new DeviceTypeExport, 'devicetypes.xlsx');
    }
}