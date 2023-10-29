<?php
namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\RepositoryInterface;

abstract class EloquentRepository implements RepositoryInterface {
    protected $model;
    public function __construct()
    {
        $this->setModel();
    }
    abstract public function getModel();
    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }
    public function all($request=[])
    {
        $result = $this->model->all();
        return $result;
    }
    public function paginate($limit,$request=[])
    {
        $items = $this->model->paginate($limit);
        return $items;
    }
    public function find($id)
    {
        return $this->model->find($id);
    }
    public function store($data)
    {
        return $this->model->create($data);
    }
    public function update($data, $id)
    {
        return $this->model->findOrFail($id)->update($data);
    }
    public function destroy($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
    
}
