<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data = [
            'title'=> $this->device->name,
            'device_id'=> $this->device_id,
            'borrow_id'=> $this->borrow_id,
            'id'=> $this->id,
            'date'=> $this->borrow_date,
            'username'=> $this->borrow->user->name,
            'lecture_name'=> $this->lecture_name,
            'lesson_name'=> $this->lesson_name,
            'session' => $this->session,
            'room'=> $this->room->name,
            'quantity'=> $this->quantity

        ];
        return $data;
    }
}
