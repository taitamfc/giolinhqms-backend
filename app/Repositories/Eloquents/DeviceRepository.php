<?php
namespace App\Repositories\Eloquents;

use App\Models\Device;
use App\Models\DeviceType;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
class DeviceRepository extends EloquentRepository implements DeviceRepositoryInterface
{
    public function getModel()
    {
        return Device::class;
    }

    /*
    - Do PostRepository đã kế thừa EloquentRepository nên không cần triển khai
    các phương thức trừu tượng của PostRepositoryInterface
    - Có thể ghi đè phương thức ở đây
    - Nếu muốn thêm phương thức mới cần:
        + Khai báo thêm ở PostRepositoryInterface
        + Triển khai lại ở đây
    - Ví dụ: paginate() không có sẵn trong RepositoryInterface, để thêm chúng ta thêm:
        + Khai báo paginate() ở PostRepositoryInterface
        + Triển khai lại ở PostRepository
    */

    public function updateQuantity($deviceId, $quantityChange)
    {
        $device = $this->model->findOrFail($deviceId);
        $device->quantity += $quantityChange;
        $device->save();
    }
    public function all($request = null)
    {
        $filter = (object)$request->filter;
        $limit = !empty($filter->limit) ? $filter->limit : 20;

        $query = $this->model->orderBy('id', 'DESC')->with('devicetype','department','classify');
        if(isset($filter->searchQuantity) && $filter->searchQuantity !== null){
            if($filter->searchQuantity  == 1){
                $query->where('quantity','>',0);
            }else {
                $query->where('quantity','=',0);
            }
        }
        if (!empty($filter->device_type_id)) {
            $query->where('device_type_id',$filter->device_type_id);
        }
        if (!empty($filter->department_id)) {
            $query->where('department_id',$filter->department_id);
        }
        
        $items = $query->paginate($limit);
    
        return $items;
    }
    

    public function paginate($limit,$request=null)
    {
        $query = $this->model->query(true);
        // dd($query);
        if($request->searchName){
            $query->where('name', 'LIKE', '%' . $request->searchName . '%');
        }
        if($request->searchDevicetype){
            $query->where('device_type_id', 'LIKE', '%' . $request->searchDevicetype . '%');
        }

        if($request->searchDepartment){
            $query->where('department_id', 'LIKE', '%' . $request->searchDepartment . '%');
        }

        if($request->searchQuantity == 1){
            $query->where('quantity', 0);
        }

        if($request->searchQuantity == 2){
            $query->where('quantity', '>', 0);
        }
        $query->orderBy('id','desc');
        $items = $query->paginate($limit);
        return $items;
    }

    public function store($data)
    {
        if( isset( $data['image']) && $data['image']->isValid() ){
            $path = $data['image']->store('public/devices');
            $url = Storage::url($path);
            $data['image'] = $url;
        }
        else {
            $data['image'] = 'asset/default/image.jpg';
        }
        return $this->model->create($data);
    }

    public function update($id,$data)
    {
         if( isset( $data['image']) && $data['image']->isValid() ){
            $path = $data['image']->store('public/devices');
            $url = Storage::url($path);
            $data['image'] = $url;
        }
        return $this->model->where('id',$id)->update($data);
    }

    public function trash($limit,$request)
    {
        $query = $this->model->onlyTrashed();

        if ($request->searchName != null) {
            $query->where('name', 'LIKE', '%' . $request->searchName . '%');
        }

        if ($request->searchDevicetype != null) {
            $query->where('device_type_id', 'LIKE', '%' . $request->searchDevicetype . '%');
        }

        $items = $query->paginate($limit);
        return $items;
    }
    public function restore($id)
    {
        $result = $this->model->withTrashed()->find($id)->restore();
        return $result;
    }

    public function forceDelete($id)
    {
        // try {

            $result = $this->model->onlyTrashed()->find($id);
            $result->forceDelete();
            return $result;

    }

}
