<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\Interfaces\DepartmentServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\ImportDepartmentsRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DepartmentsImport;

class DepartmentController extends Controller
{
    protected $departmentService;
    public function __construct(DepartmentServiceInterface $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {   
        $this->authorize('viewAny', Department::class);
        $departments = $this->departmentService->paginate(20, $request);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $this->authorize('create', Department::class);
        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {

        $data = $request->except(['_token', '_method']);
        $this->departmentService->store($data);
        return redirect()->route('departments.index')->with('success', 'Thêm mới thành công!');
    }

    public function edit($id)
    {
        $department = $this->departmentService->find($id);
        $this->authorize('update', $department);
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        $room = $this->departmentService->update($data, $id);
        return redirect()->route('departments.index')->with('success', 'Cập Nhật thành công!');
    }


    public function destroy($id)
    {   
        $department = $this->departmentService->find($id);
        $this->authorize('restore', $department);
        try {
            if ($this->departmentService->isDepartmentDevice($id)) {
                return redirect()->back()->with('error', 'Trong Thiết Bị đang có Bộ Môn này, không thể xóa!');
            }
            $this->departmentService->destroy($id);
            return redirect()->route('departments.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }


    public function trash(Request $request)
    {
        $departments = $this->departmentService->trash($request);
        return view('departments.trash', compact('departments', 'request'));
    }

    public function restore($id)
    {
        $department = $this->departmentService->find($id);
        $this->authorize('restore', $department);
        try {
            $department = $this->departmentService->restore($id);
            return redirect()->route('departments.trash')->with('success', 'Khôi phục thành công!');
        } catch (err) {
            return redirect()->route('departments.trash')->with('error', 'Khôi phục không thành công!');
        }
    }

    public function force_destroy($id)
    {
        $department = $this->departmentService->find($id);
        $this->authorize('forceDelete', $department);
        try {
            $department = $this->departmentService->forceDelete($id);
            return redirect()->route('departments.trash')->with('success', 'Xóa thành công!');
        } catch (err) {
            return redirect()->route('departments.trash')->with('error', 'Xóa không thành công!');
        }
    }
    function getImport(){
        return view('departments.import');
    }
    public function import(ImportDepartmentsRequest $request) 
    {
        try {
            Excel::import(new DepartmentsImport, request()->file('importData'));
            return redirect()->route('departments.getImport')->with('success', 'Thêm thành công');
        } catch (Exception $e) {
            return redirect()->route('departments.getImport')->with('error', 'Thêm thất bại');
        }
    }
}