<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\BorrowDevice;

class BorrowDeviceExport implements FromView
{
    public function view(): View
    {
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả'
        ];

        $query = BorrowDevice::query();

        // Kiểm tra xem các tham số tìm kiếm có tồn tại trong yêu cầu không
        if (request()->has('searchTeacher')) {
            // Sử dụng mối quan hệ để truy vấn dữ liệu từ bảng borrows
            $query->whereHas('borrow', function ($subQuery) {
                $subQuery->where('user_id', request('searchTeacher'));
            });
        }

        if (request()->has('searchName')) {
            $query->where('device_id', request('searchName'));
        }
        if (request()->has('searchSession')) {
            $query->where('session', request('searchSession'));
        }

        if (request()->has('searchBorrow_date')) {
            $query->whereHas('borrow', function ($subQuery) {
                $subQuery->where('borrow_date', request('searchBorrow_date'));
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






        // Thêm điều kiện cho các tham số tìm kiếm khác nếu cần...

        $BorrowDevices = $query->get();

        return view('exports.borrow-device', [
            'BorrowDevices' => $BorrowDevices,
            'changeStatus' => $changeStatus
        ]);
    }
}
