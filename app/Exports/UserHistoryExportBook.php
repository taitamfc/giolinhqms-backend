<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\BorrowDevice;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Excel;

class UserHistoryExportBook implements FromView
{


    public function view(): View
    {
        $users = User::all();
        // dd($users);
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả'
        ];

        return view('exports.UserHistoryBook', [
            'changeStatus' => $changeStatus,
            'users' => $users,
        ]);
    }
}

