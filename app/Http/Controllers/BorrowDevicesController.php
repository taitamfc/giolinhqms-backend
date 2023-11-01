<?php

namespace App\Http\Controllers;

use App\Models\BorrowDevice;
use App\Models\Room;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Services\Interfaces\BorrowDeviceServiceInterface;
use Illuminate\Http\Request;

use App\Http\Requests\StoreBorrow_devicesRequest;
use App\Http\Requests\UpdateBorrow_devicesRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BorrowDeviceExport;
use App\Models\Nest;
use App\Models\Borrow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BorrowDevicesController extends Controller
{
    protected $borrowdeviceService;

    public function __construct(BorrowDeviceServiceInterface $borrowdeviceService)
    {
        $this->borrowdeviceService = $borrowdeviceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', BorrowDevice::class);
        $items = $this->borrowdeviceService->paginate(20, $request);
        $nests = Nest::all();
        $users = User::orderBy('name')->get();
        // Load thông tin người mượn thông qua bảng borrows
        $items->load('borrow.user');
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả'
        ];
        $current_url = http_build_query($request->query());
        return view('borrowdevices.index', compact('items', 'changeStatus', 'nests', 'users', 'current_url'));

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrow_devices $borrow_devices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        $this->authorize('update', $data);

        // dd($data);
        $this->borrowdeviceService->update($data, $id);
        return redirect()->route('borrowdevices.index')->with('success', 'Cập nhật thành công');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->borrowdeviceService->destroy($id);
            return redirect()->route('borrowdevices.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại!');
        }
    }

    public function trash()
    {
        $items = $this->borrowdeviceService->trash();
        // Load thông tin người mượn thông qua bảng borrows
        $items->load('borrow.user');
        return view('borrowdevices.trash', compact('items'));
    }
    public function restore($id)
    {
        try {
            $items = $this->borrowdeviceService->restore($id);
            return redirect()->route('borrowdevices.trash')->with('success', 'Khôi phục thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrowdevices.trash')->with('error', 'Khôi phục không thành công!');
        }
    }
    public function forceDelete($id)
    {

        try {
            $items = $this->borrowdeviceService->forceDelete($id);
            return redirect()->route('borrowdevices.trash')->with('success', 'Xóa thành công');
        } catch (\exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('borrowdevices.trash')->with('error', 'Xóa không thành công!');
        }
    }

   public function exportSinglePage()
    {
        $query = BorrowDevice::query();

        // Kiểm tra xem các tham số tìm kiếm có tồn tại trong yêu cầu không
        if (request()->has('searchTeacher')) {
            // Sử dụng mối quan hệ để truy vấn dữ liệu từ bảng borrows
            $query->whereHas('borrow', function ($subQuery) {
                $subQuery->where('user_id', request('searchTeacher'));
            });
            $user_id = request('searchTeacher');
            $user = User::find($user_id);
        }else{
            return redirect()->route('borrowdevices.index')->with('error', 'Vui lòng chọn giáo viên');
        }

        if (request()->has('searchName')) {
            $query->where('device_id', request('searchName'));
        }
        if (request()->has('searchSession')) {
            $query->where('session', request('searchSession'));
        }

        if (request()->has('searchBorrow_date') && request()->has('searchBorrow_date_to')) {
            $start_date = Carbon::parse(request('searchBorrow_date'));
            $end_date = Carbon::parse(request('searchBorrow_date_to'));

            $query->whereHas('borrow', function ($subQuery) use ($start_date, $end_date) {
                $subQuery->whereBetween('borrow_date', [$start_date, $end_date]);
            });
        }

        if (request()->has('searchStatus')) {
            $query->where('status', request('searchStatus'));
        }
        if (request()->has('searchNest')) {
            // Sử dụng mối quan hệ để truy vấn dữ liệu từ bảng borrows
            $query->whereHas('borrow.user', function ($subQuery) {
                $subQuery->where('nest_id', request('searchNest'));
            });
        }
        if (request()->has('searchSchoolYear')) {
            $yearRange = explode(' - ', request('searchSchoolYear'));
            if (count($yearRange) == 2) {
                $startYear = trim($yearRange[0]);
                $endYear = trim($yearRange[1]);

                // Tính toán ngày bắt đầu và ngày kết thúc của năm học
                $startDate = $startYear . '-08-01'; // Năm học bắt đầu từ tháng 8
                $endDate = ($endYear + 1) . '-07-31'; // Năm học kết thúc vào tháng 7 năm sau

                // Sử dụng mối quan hệ để truy vấn dữ liệu từ bảng borrows
                $query->whereHas('borrow', function ($subQuery) use ($startDate, $endDate) {
                    $subQuery->whereBetween('borrow_date', [$startDate, $endDate]);
                });
            }
        }
        $BorrowDevices = $query->get();
        $items = [];
        foreach( $BorrowDevices as $BorrowDevice ){
            $items[$BorrowDevice->borrow_date.'-'.$BorrowDevice->room_id.'-'.$BorrowDevice->lesson_name.'-'.$BorrowDevice->session.'-'.$BorrowDevice->lecture_number][] = $BorrowDevice;
        }
        $BorrowDevices = [];
        foreach( $items as $item ){
            if( empty($item[0]) ){
                continue;
            }

            $device_names = [];
            foreach( $item as $device_item ){
                $device_names[] = $device_item->device->name;
            }
            $device_names = implode(' + ', $device_names);
            $BorrowDevices[] = [
                'borrow_date' => date('d/m/Y',strtotime($item[0]->borrow_date)),
                'return_date' => date('d/m/Y',strtotime($item[0]->return_date)),
                'created_at' => date('d/m/Y',strtotime($item[0]->created_at)),
                'device_name' => $device_names,
                'quantity' => $item[0]->quantity,
                'lecture_name' => $item[0]->lecture_name,
                'lesson_name' => $item[0]->lesson_name,
                'room_name' => !empty($item[0]->room->name) ? $item[0]->room->name : '',
                'user_name' => !empty($item[0]->borrow->user) ? $item[0]->borrow->user->name : '',
            ];
        }

        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('uploads/so-muon-v2.xlsx');

        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);

        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('H2', 'Môn dạy');
        $sheet->setCellValue('B4', 'Ngày dạy');
        $borrowerName = $user->name;
        $sheet->setCellValue('E2', $borrowerName);
        $sheet->getStyle('K2')->getFont()->setSize(14);

        $index = 6;
        $stt = 1; // Khởi tạo biến STT bên ngoài vòng lặp

        foreach ($BorrowDevices as $key => $item) {
            $sheet->setCellValueExplicit('A' . $index, $key + 1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
            $sheet->setCellValue('B' . $index, $item['borrow_date']);
            $sheet->setCellValue('C' . $index, $item['return_date']);
            $sheet->setCellValue('D' . $index, $key + 1);
            $sheet->setCellValue('E' . $index, $item['created_at']);
            $sheet->setCellValue('F' . $index, $item['device_name']);
            $sheet->setCellValue('G' . $index, $item['quantity']);
            $sheet->setCellValue('H' . $index, $item['lecture_name']);
            $sheet->setCellValue('I' . $index, $item['lesson_name']);
            $sheet->setCellValue('J' . $index, $item['room_name']);
            $sheet->setCellValue('K' . $index, '');
            $sheet->getColumnDimension('L')->setWidth(50); 
            $sheet->setCellValue('L' . $index, $item['user_name']);

            $index++;
            $stt++;
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('storage/uploads/so-muon-'.$user_id.'-'.date("Y-m-d").'.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);

        return response()->download($newFilePath)->deleteFileAfterSend(true);
    }


    public function testHTML()
    {
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả'

        ];
        $BorrowDevices = BorrowDevice::all();
        return view('exportExcel.BorrowDevice', compact(['BorrowDevices', 'changeStatus']));
    }
}
