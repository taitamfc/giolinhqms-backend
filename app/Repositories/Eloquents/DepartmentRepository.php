<?php

namespace App\Repositories\Eloquents;

use App\Models\Department;
use App\Models\Device;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;



class DepartmentRepository extends EloquentRepository implements DepartmentRepositoryInterface
{
    public function getModel()
    {
        return Department::class;
    }
    public function paginate($limit,$request=null)
    {
        $query = $this->model->select('*');

        if ($request->searchname) {
            $query->where('name', 'like', '%' . $request->searchname . '%');
        }
        return $query->orderBy('id', 'DESC')->paginate(20);
    }


    public function isDepartmentDevice($id){
        return Device::where('department_id', $id)->exists();
    }
    

    public function trash($request = null)
    {
        $query = $this->model->onlyTrashed();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        return $query->orderBy('id', 'DESC')->paginate(20);

    }

    public function restore($id)
    {
        return Department::withTrashed()->find($id)->restore();
    }

    public function forceDelete($id)
    {
        return $this->model->onlyTrashed()->find($id)->forceDelete();

    }
    
}
