<?php
namespace App\Repositories\Eloquents;

use App\Models\BorrowDevice;
use App\Repositories\Interfaces\BorrowDeviceRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
class BorrowDeviceRepository extends EloquentRepository implements  BorrowDeviceRepositoryInterface
{
    public function getModel()
    {
        return BorrowDevice::class;
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
    public function paginate($limit,$request=null)
    {
        $query = $this->model->with('device');
        // Thay đổi từ 'user_id' thành 'user.name'
        if ($request && $request->searchName) {
            $query->whereHas('device', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchName . '%');
            });
        }
        if($request->searchSession){
            $query->where('session', 'LIKE', '%' . $request->searchSession . '%');
        }
        if($request->searchQuantity){
            $query->where('quantity', 'LIKE', '%' . $request->searchQuantity . '%');
        }
        if ($request->searchTeacher) {
            $query->whereHas('borrow.user', function ($query) use ($request) {
                $query->where('id', $request->searchTeacher);
            });
        }
        if ($request->searchBorrow_date) {
            $query->whereHas('borrow', function ($query) use ($request) {
                $query->where('borrow_date', '>=', $request->searchBorrow_date );
            });
        }

        if ($request->searchBorrow_date_to) {
            $query->whereHas('borrow', function ($query) use ($request) {
                $query->where('borrow_date','<=', $request->searchBorrow_date_to );
            });
        }
        if($request->searchStatus !== null){
            $query->where('status',$request->searchStatus);
        }
        if ($request->searchNest) {
            $query->whereHas('borrow.user', function ($query) use ($request) {
                $query->where('nest_id', $request->searchNest);
            });
        }
        if (request()->has('searchSchoolYear')) {
            $yearRange = explode(' - ', request('searchSchoolYear')); // Tách chuỗi thành mảng [Năm bắt đầu, Năm kết thúc]
            if (count($yearRange) == 2) {
                $startYear = trim($yearRange[0]); // Năm bắt đầu
                $endYear = trim($yearRange[1]); // Năm kết thúc

                // Tính toán ngày bắt đầu và ngày kết thúc dựa vào năm học
                $startDate = $startYear . '-08-01'; // Năm học bắt đầu từ tháng 8
                $endDate = $endYear . '-07-01'; // Năm học kết thúc vào tháng 7 năm sau

                // Sử dụng mối quan hệ để truy vấn dữ liệu từ bảng borrows
                $query->whereHas('borrow', function ($subQuery) use ($startDate, $endDate) {
                    $subQuery->whereBetween('borrow_date', [$startDate, $endDate]);
                });
            }
        }

        // Khong lay phieu da xoa
        $query->whereHas('borrow', function ($query) use ($request) {
            $query->where('deleted_at', NULL);
        });
        $query->orderBy('id','desc');
        $items = $query->paginate($limit);
        return $items;
    }

    // public function store($data)
    // {
    //     if( isset( $data['image']) && $data['image']->isValid() ){
    //         $path = $data['image']->store('public/devices');
    //         $url = Storage::url($path);
    //         $data['image'] = $url;
    //     }
    //     return $this->model->create($data);
    // }

    // public function update($id,$data)
    // {
    //      if( isset( $data['image']) && $data['image']->isValid() ){
    //         $path = $data['image']->store('public/devices');
    //         $url = Storage::url($path);
    //         $data['image'] = $url;
    //     }
    //     return $this->model->where('id',$id)->update($data);
    // }

    public function trash()
    {
        $result = $this->model->onlyTrashed()->get();
        return $result;
    }
    public function restore($id)
    {
        $result = $this->model->withTrashed()->find($id)->restore();
        return $result;
    }

    public function forceDelete($id)
    {

            $result = $this->model->onlyTrashed()->find($id);
            $result->forceDelete();
            return $result;

    }

}
