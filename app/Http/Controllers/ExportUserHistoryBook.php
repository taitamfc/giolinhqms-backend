<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExportUserHistoryBook extends Controller
{
    public function export_history_book($id)
    {
        // dd(123);
        $user = User::findOrFail($id);
        $borrows = Borrow::where('user_id', $id)->get();

        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('uploads/so-muon-v2.xlsx');


        // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);


        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('D2', $user->name);
        $sheet->setCellValue('H2', '');
        $sheet->setCellValue('K2', $user->nest->name);
        $sheet->getStyle('K2')->getFont()->setSize(14);

        // dd($borrows);
        $index = 6;
        $stt = 1; // Khởi tạo biến STT bên ngoài vòng lặp

        foreach ($borrows as $borrow) {
            foreach ($borrow->the_devices as $device) {
                //cột ngày mượn
                $sheet->setCellValueExplicit('A' . $index, $stt, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->getStyle('A' . $index)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_GENERAL);
                $sheet->setCellValue('B' . $index, Carbon::parse($borrow->borrow_date)->format('d/m/Y'));
                $sheet->setCellValue('C' . $index, Carbon::parse($device->return_date)->format('d/m/Y'));
                $sheet->setCellValue('D' . $index, $device->id);
                $sheet->setCellValue('E' . $index, Carbon::parse($device->created_at)->format('d/m/Y'));
                $sheet->setCellValue('F' . $index, $device->device ? $device->device->name : '');
                $sheet->setCellValue('G' . $index, $device->quantity);
                $sheet->setCellValue('H' . $index, $device->lecture_name);
                $sheet->setCellValue('I' . $index, $device->lesson_name);
                $sheet->setCellValue('J' . $index, $device->room ? $device->room->name : '');
                $sheet->setCellValue('K' . $index, '');
                $sheet->setCellValue('L' . $index, '');
                $index++;
                $stt++; // Tăng giá trị STT sau mỗi lần lặp
            }
        }


        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('storage/uploads/so-muon-v2' . time() . '.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);


        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save($newFilePath);
        return response()->download($newFilePath)->deleteFileAfterSend(true);
    }
}
