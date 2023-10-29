<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $tong_muon = $this->the_devices()->count();
        $tong_tra = $this->the_devices()->where('status', 1)->count();

        switch ($this->approved) {
            case 1:
                $approved_format = 'Đã xét duyệt';
                break;
            case 2:
                $approved_format = 'Từ chối';
                break;
            default:
                $approved_format = 'Chưa xét duyệt';
                break;
        }

        $data['tong_muon']  = $tong_muon;
        $data['tong_tra']   = $tong_tra;
        $data['created_date_format']    = date('d/m/Y',strtotime($this->created_at));
        $data['borrow_date_format']     = date('d/m/Y',strtotime($this->borrow_date));
        $data['status_format']          = $this->status == 1 ? 'Đã trả' : 'Chưa trả';
        $data['approved_format']        = $approved_format;
        $data['user_name']              = $this->user ? $this->user->name : 'Hệ thống';
        
        unset($data['user_id']);
        return $data;
    }
}
