<?php

namespace App\Repositories\Eloquents;

use App\Models\Borrow;
use App\Models\BorrowDevice;
use App\Models\Device;
use App\Repositories\Interfaces\BorrowRepositoryInterface;
use App\Repositories\Eloquents\EloquentRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class BorrowRepository extends EloquentRepository implements BorrowRepositoryInterface
{
    public function getModel()
    {
        return Borrow::class;
    }


    public function paginate($limit, $request = null)
    {
        $subquery = $this->model
            ->select('user_id')
            ->groupBy('user_id');
        $query = $this->model->query (true);

        if($request->searchName){
            $query->where('user_id',$request->searchName);
        }
        if($request->nest_id){
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('nest_id', '=', $request->nest_id );
            });
        }

        if ($request && $request->searchBorrow_date_from) {
            $query->where('borrow_date', '>=', $request->searchBorrow_date_from);
        }

        if ($request && $request->searchBorrow_date_to) {
            $query->where('borrow_date', '<=', $request->searchBorrow_date_to);
        }
        if($request->searchStatus !== null){
            $query->where('status',$request->searchStatus);
        }
        if ($request->searchApproved !== null) {
            $query->where('approved',$request->searchApproved);
        }
        if ($request && $request->searchSchoolYear) {
            $yearRange = explode(' - ', $request->searchSchoolYear);
            if (count($yearRange) == 2) {
                // Lấy năm bắt đầu và năm kết thúc từ định dạng năm học
                $startYear = trim($yearRange[0]);
                $endYear = trim($yearRange[1]);

                // Tính toán ngày bắt đầu và ngày kết thúc dựa vào năm học
                $startDate = $startYear . '-08-01'; // Năm học bắt đầu từ tháng 8
                $endDate = $endYear . '-07-01'; // Năm học kết thúc vào tháng 7 năm sau

                $query->whereBetween('borrow_date', [$startDate, $endDate]);
            }
        }


        $query->orderBy('id','desc');
        $items = $query->paginate($limit);

        return $items;
    }




    public function store($data)
    {
        $userData = [
            'user_id' => $data['user_id'],
            'borrow_date' => $data['borrow_date'],
            'borrow_note' => $data['borrow_note'],
            'status' => isset($data['status']) ? $data['status'] :0,
            'approved' => isset($data['approved']) ? $data['approved'] :0,
            // 'created_at' => isset($data['created_at']) ? $data['created_at'] : date('Y-m-d H:i:s')

        ];

        $deviceData = [];
        foreach ($data['devices']['id'] as $key => $deviceId) {
            $deviceData[] = [
                'device_id' => $deviceId,
                'room_id' => $data['devices']['room_id'][$key],
                'lesson_name' => $data['devices']['lesson_name'][$key],
                'quantity' => $data['devices']['quantity'][$key],
                'session' => $data['devices']['session'][$key],
                'lecture_name' => $data['devices']['lecture_name'][$key],
                'lecture_number' => $data['devices']['lecture_number'][$key],
                'return_date' => $data['devices']['return_date'][$key],
                // 'borrow_date'  => $data['borrow_date'],
                'status' => isset($data['status']) ? $data['status'] :0,
                // 'created_at' => isset($data['created_at']) ? $data['created_at'] : date('Y-m-d H:i:s')

            ];
        }

        // Tạo bản ghi borrow mới
        $borrow = $this->model->create($userData);

        // Thêm nhiều bản ghi borrow_device mới
        $borrow->the_devices()->createMany($deviceData);

         // Khi xét duyệt, trừ số lượng
        if(isset($data['approved']) && $data['approved'] == 1){
            // Cập nhật số lượng trong bảng devices
            foreach ($deviceData as $device) {
               $this->updateDeviceQuantity($device['device_id'], -$device['quantity']);
            }
        }

        return $borrow;
    }

    public function trash($request = null)
    {
        $query = $this->model->onlyTrashed()->with(['user:id,name']);

        if($request->searchStatus !== null){
            $query->where('status',$request->searchStatus);
        }
        if ($request->searchApproved !== null) {
            $query->where('approved',$request->searchApproved);
        }
        if ($request->searchBorrow_date) {
            $query->where('borrow_date', 'like', '%' . $request->searchBorrow_date . '%');
        }

        if ($request->searchName) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->searchName . '%');
            });
        }

        return $query->orderBy('id', 'DESC')->paginate(11);
    }


    public function restore($id)
    {
        $result = $this->model->withTrashed()->find($id)->restore();
        return $result;
    }

    public function forceDelete($id)
    {
        // Tìm bản ghi trong bảng "borrow" kèm theo cả bản ghi đã bị xóa (soft deleted)
        $borrow = $this->model->withTrashed()->find($id);

        if ($borrow) {
            // Lấy danh sách các bản ghi "borrow_devices" liên quan đến bản ghi "borrow"
            $relatedDevices = $borrow->the_devices;

            // Xóa các bản ghi liên quan trong bảng "borrow_devices" trước
            foreach ($relatedDevices as $device) {
                $device->forceDelete();
            }

            // Cuối cùng, xóa bản ghi trong bảng "borrow"
            $borrow->forceDelete();

            return $borrow;
        } else {
            // Xử lý trường hợp không tìm thấy bản ghi
            // Ví dụ: throw exception hoặc trả về thông báo lỗi
        }
    }
    public function update($data, $id)
    {
        $userData = [
            'user_id' => $data['user_id'],
            'borrow_date' => $data['borrow_date'],
            'borrow_note' => $data['borrow_note'],
            'status' => isset($data['status']) ? $data['status'] :0,
            'approved' => isset($data['approved']) ? $data['approved'] :0,
        ];

        if(isset($data['created_at']) && $data['created_at']){
            // $userData['created_at'] = $data['created_at'];
        }

        $borrow = $this->model->findOrFail($id);
        $borrow->update($userData);
        // $currentDeviceIds = $borrow->the_devices->pluck('device_id')->toArray();
        $deviceData = [];
        $deviceIds = [];
        foreach ($data['devices']['id'] as $key => $deviceId) {
            $deviceData[] = [
                'device_id' => $deviceId,
                'room_id' => $data['devices']['room_id'][$key],
                'lesson_name' => $data['devices']['lesson_name'][$key],
                'quantity' => $data['devices']['quantity'][$key],
                'session' => $data['devices']['session'][$key],
                'lecture_name' => $data['devices']['lecture_name'][$key],
                'lecture_number' => $data['devices']['lecture_number'][$key],
                'return_date' => $data['devices']['return_date'][$key],
                'borrow_date'  => $data['borrow_date'],
                'status' => $data['status'],
                // 'created_at' => $data['created_at']
            ];
        }
        // foreach ($borrow->the_devices as $the_device) {
        //     $the_device->delete();
        // }
        // dd($borrow->the_devices);
        // $borrow->the_devices()
        //         ->where('borrow_id', $id)
        //         ->delete();
        $borrow->the_devices()->forceDelete();
        $borrow->the_devices()->createMany($deviceData);

        // Khi xét duyệt, trừ số lượng
        if($data['approved'] == 1){
             // Cập nhật số lượng trong bảng devices
            foreach ($deviceData as $device) {
                $this->updateDeviceQuantity($device['device_id'], -$device['quantity']);
            }

        }

        return true;
    }

    public function updateDeviceQuantity($deviceId, $quantityChange)
    {
        $device = Device::findOrFail($deviceId);
        $device->quantity += $quantityChange;
        $device->save();

    }

    // Lấy borrow
    public function all($request = null)
    {
        $query = $this->model->orderBy('id', 'DESC');

        $filter = (object)$request->filter;
        $limit = !empty($filter->limit) ? $filter->limit : 20;
        if (!empty($filter->searchBorrowDate)) {
            $query->where('borrow_date', '>=', $filter->searchBorrowDate);
        }
        if (!empty($filter->searchBorrowDate_to)) {
            $query->where('borrow_date', '<=', $filter->searchBorrowDate_to);
        }
        if(isset($filter->searchStatus) && $filter->searchStatus !== null){
            $query->where('status',$filter->searchStatus);
        }
        if(isset($filter->searchApproved) && $filter->searchApproved !== null){
            $query->where('approved',$filter->searchApproved);
        }
        if (!empty($filter->user_id)) {
            $query->where('user_id',$filter->user_id);
        }
        $items = $query->paginate($limit);
        return $items;
    }

    public function updateBorrow($id, $data)
    {
        // Tìm phiếu mượn theo ID
        $borrow = $this->model->findOrFail($id);

        // Lấy trạng thái xét duyệt hiện tại
        $currentApprovedStatus = $borrow->approved;

        // Lấy trạng thái mới từ dữ liệu gửi đến
        $newApprovedStatus = $data['approved'];

        // Kiểm tra nếu trạng thái đã xét duyệt thay đổi thành chưa xét duyệt hoặc từ chối => OK
        // Đã xét duyệt => Chưa xét duyệt => số lượng cộng
        if ($currentApprovedStatus == 1 && ($newApprovedStatus == 0 || $newApprovedStatus == 2)) {
            // Trả lại số lượng thiết bị cho bảng device tương ứng
            foreach ($borrow->the_devices as $borrow_device) {
                // Nếu thiết đã trả thì không cộng
                if($borrow_device->status == 1){

                }else{
                    // Chưa trả thì cộng
                    $this->updateDeviceQuantity($borrow_device->device_id, $borrow_device->quantity);
                }
                $borrow_device->status = 0;
                $borrow_device->save();
            }

        }
        // Kiểm tra nếu trạng thái chưa xét duyệt hoặc từ chối thay đổi thành đã xét duyệt
        // Chưa xét duyệt => Đã xét duyệt => số lượng trừ
        elseif (($currentApprovedStatus == 0 || $currentApprovedStatus == 2) && $newApprovedStatus == 1) {
            // Trừ đi số lượng thiết bị cho bảng device tương ứng
            foreach ($borrow->the_devices as $borrow_device) {
                $this->updateDeviceQuantity($borrow_device->device_id, -$borrow_device->quantity);
            }

        }else{
            // Đã xét duyệt và thực hiện trả
            // Cập nhật trạng thái và số lượng trong bảng borrow_device
            if (isset($data['the_device_status'])) {
                $borrow_device_ids = $data['the_device_status'];
                foreach ($borrow_device_ids as $borrow_device_id => $device_status) {
                    // Cập nhật status trong database
                    $borrow_device = $borrow->the_devices()->where('id', $borrow_device_id)->first();

                    $borrow_device_old_status = $borrow_device->status;
                    $borrow_device_new_status = $device_status;

                    $borrow_device->status = $device_status;
                    $borrow_device->save();

                    // Cập nhật số lương

                    // Nếu trả
                    if( $borrow_device_old_status == 0 && $borrow_device_new_status == 1 ){
                        $this->updateDeviceQuantity($borrow_device->device_id,$borrow_device->quantity);
                    }
                    // Nếu trả rồi, nhưng cập nhật lại chưa trả
                    if( $borrow_device_old_status == 1 && $borrow_device_new_status == 0 ){
                        $this->updateDeviceQuantity($borrow_device->device_id,-$borrow_device->quantity);
                    }
                }
            }
        }
        // Cập nhật trạng thái xét duyệt từ dữ liệu gửi đến
        $borrow->approved = $newApprovedStatus;

        // Cập nhật trạng thái từ dữ liệu gửi đến (nếu có)
        if (isset($data['status'])) {
            $borrow->status = $data['status'];
        }



        // Tính tổng số thiết bị mượn và trả
        $tong_muon = $borrow->the_devices()->count();
        $tong_tra = $borrow->the_devices()->where('status', 1)->count();

        // Tự động cập nhật trạng thái phiếu mượn nếu đã trả hết
        if ($tong_tra == $tong_muon) {
            $borrow->status = 1;
        }


        // Lưu các thay đổi
        $borrow->save();

        return $borrow;
    }

    // public function destroy($id){
    //     return $this->borrowRepository->destroy($id);
    // }
}
