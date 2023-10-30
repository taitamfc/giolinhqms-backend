<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Device;
use App\Models\BorrowDevice;
use App\Services\Interfaces\BorrowServiceInterface;
use App\Services\Interfaces\DeviceServiceInterface;
use App\Http\Resources\BorrowResource;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Log;

class BorrowController extends Controller
{
    protected $approved_labels = [
        'Chưa xét duyệt',
        'Đã duyệt',
        'Từ chối',
    ];
    protected $status_labels = [
        'Chưa trả',
        'Đã trả',
    ];
    private $borrowService;
    private $deviceService;
    public function __construct(
        BorrowServiceInterface $borrowService
        , DeviceServiceInterface $deviceService
    ) {
        $this->borrowService = $borrowService;
        $this->deviceService = $deviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->borrowService->all($request);
        return BorrowResource::collection($items);
        // Sau return các đoạn mã phía dưới sẽ không chạy
        
        // Thêm tính toán tong_muon và tong_tra cho mỗi $item
        foreach ($items as $key => $item) {
            $tong_muon = $item->the_devices()->count();
            $tong_tra = $item->the_devices()->where('status', 1)->count();

            // Thêm vào dữ liệu của mỗi $item
            $items[$key]->tong_muon = $tong_muon;
            $items[$key]->tong_tra = $tong_tra;
        }

        return response()->json($items, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        // dd($data);
        $createdBorrow = $this->borrowService->store($data);
        return response()->json($createdBorrow, 200);
    }

   
    public function update(Request $request, $id)
    {
        // Tìm phiếu mượn cần cập nhật
        $borrow = $this->borrowService->find($id);
    
        if (!$borrow) {
            return response()->json([
                "success" => false,
                "message" => "Không tìm thấy phiếu mượn",
            ], 404);
        }
    
        // Cập nhật thông tin của phiếu mượn
        $data = $request->except(['_token', '_method']);
        $updatedBorrow = $this->borrowService->update($data, $id);
    
        return response()->json([
            "success" => true,
            "message" => "Cập nhật phiếu mượn thành công",
            "borrow" => $updatedBorrow,
        ], 200);
    }

    // public function update(Request $request, $id)
    // {
    //     // Tìm phiếu mượn cần cập nhật
    //     $borrow = Borrow::find($id);

    //     if (!$borrow) {
    //         return response()->json([
    //             "success" => false,
    //             "message" => "Không tìm thấy phiếu mượn",
    //         ], 404);
    //     }

    //     // Cập nhật thông tin của phiếu mượn
    //     $borrow->borrow_date = $request->input('borrow_date');
    //     $borrow->borrow_note = $request->input('borrow_note');
    //     $borrow->save();

    //     if ($request->input('devices') && count($request->input('devices'))) {
    //         // Xóa tất cả các thiết bị liên quan đến phiếu mượn
    //         $borrow->devices()->detach();

    //         // Thêm lại các thiết bị sau khi cập nhật
    //         foreach ($request->input('devices') as $deviceData) {
    //             $borrow->devices()->attach($deviceData['id'], [
    //                 'lesson_name' => $deviceData['lesson_name'],
    //                 'quantity' => $deviceData['quantity'],
    //                 'session' => $deviceData['session'],
    //                 'lecture_name' => $deviceData['lecture_name'],
    //                 'room_id' => $deviceData['room_id'],
    //                 'lecture_number' => $deviceData['lecture_number'],
    //                 'return_date' => $deviceData['return_date'],
    //             ]);
    //         }
    //     }


    //     return response()->json([
    //         "success" => true,
    //         "message" => "Cập nhật phiếu mượn thành công",
    //         "borrow" => $borrow,
    //     ], 200);
    // }
   
    
    public function show(string $id)
    {
        $item = $this->borrowService->find($id);
        $item->user = $item->user;
        $item->approved_label       = $this->approved_labels[$item->approved];
        $item->status_label         = $this->status_labels[$item->status];
        $item->created_at_label     = date('d/m/Y H:i',strtotime($item->created_at));
        $item->borrow_date_label     = date('d/m/Y',strtotime($item->borrow_date));
        $devices = $item->devices;
        $the_devices = $item->the_devices;
        
        return response()->json([
            "success" => true,
            "data" => $item,
        ]);
    }
    public function destroy(string $id)
    {
        $this->borrowService->destroy($id);
        return response()->json([
            "success" => true,
            "message" => "Xóa thành công",
        ]);
    }

    public function checkBorrow(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $device_ids = $request->devices['id'];
        $sessions = $request->devices['session'];
        $lecture_numbers = $request->devices['lecture_number'];
        $borrow_date = $request->borrow_date;
        $errors = [];
        foreach ($device_ids as $key => $device_id){
            $session = $sessions[$key];
            $lecture_number = $lecture_numbers[$key];
            
            $device = Device::find($device_id);
            if($device->quantity <= 0){
                $borrow_device = BorrowDevice::where('device_id', $device_id)
                ->where('session',$session)
                ->where('lecture_number',$lecture_number)
                ->where('borrow_date',$borrow_date)
                ->first();
    
                if($borrow_device){
                    $errors[] = [
                        'title'=> $borrow_device->device->name,
                        'session' => $borrow_device->session,
                        'lecture_number' => $lecture_number,
                        'room'=> $borrow_device->room->name,
                        'quantity'=> $borrow_device->quantity,
                        'username'=> $borrow_device->borrow->user->name,
                        'date'=> $borrow_device->borrow_date,
                    ];
                }
            }
            

        }

        $error_html = '<table class="table table-bordered">';
            $error_html .= '<tr>';
                $error_html .= '<td>Tên thiết bị</td>';
                $error_html .= '<td>Ngày dạy</td>';
                $error_html .= '<td>Buổi</td>';
                $error_html .= '<td>Tiết</td>';
                $error_html .= '<td>SL</td>';
                $error_html .= '<td>Người mượn</td>';
            $error_html .= '</tr>';
        foreach($errors as $error){
            $error_html .= '<tr>';
                $error_html .= '<td>'.$error['title'].'</td>';
                $error_html .= '<td>'.$error['date'].'</td>';
                $error_html .= '<td>'.$error['session'].'</td>';
                $error_html .= '<td>'.$error['lecture_number'].'</td>';
                $error_html .= '<td>'.$error['quantity'].'</td>';
                $error_html .= '<td>'.$error['username'].'</td>';
            $error_html .= '</tr>';
        }
        $error_html .= '</table>';
        return response()->json([
            "success" => count($errors) ? false : true,
            "errors" => $errors,
            "error_html" => $error_html,
        ]);
    }
}