<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExportBorrow extends Controller
{
    public function export_borrow($id)
    {
        // Lấy thông tin người dùng và mượn thiết bị
        $borrow = Borrow::find($id);
        $user = $borrow->user;

        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('uploads/exportborrow.xlsx');

        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);

        // Lấy ngày, tháng và năm hiện tại
        $currentDay = date('d');
        $currentMonth = date('m');
        $currentYear = date('Y');
        $newValue = 'Gio Linh, ngày ' . $currentDay . ' tháng ' . $currentMonth . ' năm ' . $currentYear;
       
        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('C7', $user->name);
        $sheet->setCellValue('C8', $user->nest->name);
        $sheet->setCellValue('D31', $user->name);
        $sheet->setCellValue('C27', $newValue);


        // $sheet->setCellValue('B9', 'Tên TB cần sử dụng');
        // $sheet->setCellValue('C9', 'Tên bài dạy');
        // $sheet->setCellValue('D9', 'Ngày sử dụng');
        // $sheet->setCellValue('E9', 'Tiết PPCT');
        // $sheet->setCellValue('F9', 'Số lượng');
        // $sheet->setCellValue('G9', 'Tiết TKB');
        // $sheet->setCellValue('H9', 'Lớp');

        // Đặt rộng các cột B đến H
        //  $sheet->getColumnDimension('B')->setWidth(30);
        //  $sheet->getColumnDimension('C')->setWidth(30);
        //  $sheet->getColumnDimension('D')->setWidth(20);
        //  $sheet->getColumnDimension('E')->setWidth(15);
        //  $sheet->getColumnDimension('F')->setWidth(15);
        //  $sheet->getColumnDimension('G')->setWidth(15);
        //  $sheet->getColumnDimension('H')->setWidth(15);


        // Duyệt qua danh sách mượn thiết bị
        $index = 10; // Bắt đầu từ hàng 10
        $stt = 1; // Khởi tạo biến STT

        foreach ($borrow->the_devices as $device) {
            $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
            $sheet->setCellValue('B' . $index, $device->device ? $device->device->name : '');
            $sheet->setCellValue('C' . $index, $device->lesson_name);
            $sheet->setCellValue('D' . $index, Carbon::parse($borrow->borrow_date)->format('d/m/Y'));
            $sheet->setCellValue('E' . $index, $device->lecture_name);
            $sheet->setCellValue('F' . $index, $device->quantity);
            $sheet->setCellValue('H' . $index, $device->room ? $device->room->name : '');
            $sheet->setCellValue('G' . $index, $device->lecture_number);
            $index++;
            $stt++;
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('uploads/phieu-bao-muon-' . $borrow->id . '.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);

        return response()->download($newFilePath)->deleteFileAfterSend(true);
    }

}