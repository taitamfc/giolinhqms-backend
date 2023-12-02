<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;
use App\Models\BorrowDevice;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Dompdf\FrameReflower\Page;

class ExportBookController extends Controller
{
    public function export(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $changeStatus = [
            0 => 'Chưa trả',
            1=> 'Đã trả'
        ];
        $number = 0;
        $borrowDevices = BorrowDevice::whereHas('borrow', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->with('borrow', 'device', 'room', 'user')->get();

        $pdf = PDF::loadView('users.bookPDF.book', compact('user','borrowDevices','changeStatus','number'))->setPaper('a4', 'landscape');
        return $pdf->download('SoMuon.pdf');
    }
}