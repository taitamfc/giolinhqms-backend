<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowDevice;
use App\Models\User;
use PDF;

class PDFController extends Controller
{

    public function exportPDF($id)
    {
        $item = Borrow::with('the_devices', 'user', 'the_rooms', 'devices')->orderBy('id', 'DESC')->findOrFail($id);
        // dd($item->created_at);
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả',
        ];
        $pdf = PDF::loadView('borrows.pdf', compact('item', 'changeStatus'))->setPaper('a4', 'landscape');
        return $pdf->download('phieumuon.pdf');
    }
}
