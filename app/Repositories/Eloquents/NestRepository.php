<?php

namespace App\Repositories\Eloquents;

use App\Models\Nest;
use App\Models\User;
use App\Repositories\Interfaces\NestRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;

class NestRepository extends EloquentRepository implements NestRepositoryInterface
{
    public function getModel()
    {
        return Nest::class;
    }
    public function all($request = null)
    {
        $query = $this->model->select('*');

        if ($request->searchname) {
            $query->where('name', 'like', '%' . $request->searchname . '%');
        }
        if ($request->id) {
            $query->where('id', $request->id);
        }
        return $query->orderBy('id', 'DESC')->paginate(20);
    }

    public function trash($request = null)
    {
        $query = $this->model->onlyTrashed();

        if ($request->searchName) {
            $query->where('name', 'like', '%' . $request->searchName . '%');
        }
        return $query->orderBy('id', 'DESC')->paginate(20);
    }
    public function restore($id)
    {
        return Nest::withTrashed()->find($id)->restore();
    }
    public function forceDelete($id)
    {
        return $this->model->onlyTrashed()->find($id)->forceDelete();
    }
    public function isUserNest($id) {
        return User::where('nest_id', $id)->exists();
    }
}
