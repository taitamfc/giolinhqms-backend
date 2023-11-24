<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
// use validate
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;

// use import & validate excel
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetImport;
use App\Exports\AssetsExport;
use App\Http\Requests\ImportAssetRequest;

//use model
use App\Models\DeviceType;
use App\Models\Department;
use App\Models\Device;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $this->authorize('viewAny', Asset::class);
        $query = Asset::orderBy('id', 'DESC')->with('devicetype','department');
        if(isset($request->searchQuantity) && $request->searchQuantity !== null){
            if($request->searchQuantity  == 2){
                $query->where('quantity','>',0);
            }else {
                $query->where('quantity','=',0);
            }
        }
        if (!empty($request->searchName)) {
            $query->where('name',$request->searchName);
        }
        if (!empty($request->searchDevicetype)) {
            $query->where('device_type_id',$request->searchDevicetype);
        }
        if (!empty($request->searchDepartment)) {
            $query->where('department_id',$request->searchDepartment);
        }
        
        $items = $query->paginate(20);
        $devicetypes = DeviceType::get();
        $departments = Department::get();
        return view('assets.index', compact('items','request','devicetypes','departments'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Asset::class);
        $devicetypes = DeviceType::get();
        $departments = Department::get();
        return view('assets.create',compact(['devicetypes','departments']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request)
    {
        $data = $request->except(['_token', '_method']);
        Asset::create($data);
        return redirect()->route('assets.index')->with('success', 'Thêm tài sản thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $item = Asset::findOrfail($id);
        $this->authorize('view', $item);
        return view('assets.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $item = Asset::findOrfail($id);
        $this->authorize('update', $item);
        $devicetypes = DeviceType::get();
        $departments = Department::get();
        return view('assets.edit', compact('item','devicetypes','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, String $id)
    {
        $data = $request->except(['_token', '_method']);
        $asset = Asset::find($id);
        $asset->update($data);
        return redirect()->route('assets.index')->with('success', 'Cập nhật thiết bị thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash(Request $request)
    {
        try {
            $this->authorize('trash', Asset::class);
            $devicetypes = DeviceType::get();
            $items = Asset::onlyTrashed();
            if ($request->searchDevicetype) {
                $items->where('device_type_id',$request->searchDevicetype);
            }
            if ($request->searchName) {
                $items->where('name','LIKE','%'.$request->searchName.'%');
            }
            $items = $items->paginate(20);
            return view('assets.trash', compact('items','devicetypes','request'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thất bại!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            $item = Asset::find($id);
            $this->authorize('delete', $item);
            $item->delete();
            return redirect()->back()->with('success', 'Xóa tài sản thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }
    function restore(String $id){
        try {
            $asset = Asset::withTrashed()->find($id);
            $this->authorize('restore',$asset);
            $asset->restore();
            return redirect()->route('assets.index');
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            alert()->warning('Have problem! Please try again late');
            return back();
        }
    }
    function forceDelete(String $id){
        try {
            $asset = Asset::withTrashed()->find($id);
            $this->authorize('forceDelete',$asset);
            $path = $asset->image;
            if (file_exists($path)) {
                unlink($path);
            }
            $asset->forceDelete();
            alert()->success('Destroy asset success');
            return back();
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            alert()->warning('Have problem! Please try again late');
            return back();
        }
    }
    function getImport(){
        return view('assets.import');
    }
    public function import(ImportAssetRequest $request) 
    {
        try {
            // Excel::import(new DeviceImport, request()->file('importData'));
            $import = new AssetImport();
            Excel::import($import, request()->file('importData'));
            return redirect()->route('assets.getImport')->with('success', 'Thêm thành công');
        } catch (Exception $e) {
            return redirect()->route('assets.getImport')->with('error', 'Thêm thất bại');
        }
    }
    function export(){
        return Excel::download(new AssetsExport, 'assets.xlsx');
    }
}