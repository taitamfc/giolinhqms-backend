<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class DeviceResource extends JsonResource
{

    //DeviceResource là một lớp mở rộng từ JsonResource, một class có sẵn trong Laravel để xử lý việc định dạng và trả về dữ liệu dưới dạng JSON

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


    //toArray : biến đổi đối tượng người dùng thành một mảng dữ liệu có cấu trúc cụ thể.
    public function toArray(Request $request): array
    {
        //gọi phương thức toArray của lớp cha để lấy một mảng dữ liệu cơ bản của người dùng.
        $data = parent::toArray($request);

        //đoạn dưới thì chắc các bạn đã hiểu rồi (thay vì trả về dử liệu thô thì nó sẻ trả về tên của foreign key)
        // $data['nest_id'] = $this->nest->name ?? "";
        $data['url_image'] = URL::to($this->image);
        return $data;
    }
    //sư dụng DeviceResource :  Bạn có thể thêm, loại bỏ hoặc biến đổi thông tin trước khi gửi dữ liệu về cho người dùng.
}
