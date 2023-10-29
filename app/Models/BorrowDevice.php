<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowDevice extends Model
{
    use HasFactory;
    protected $table ='borrow_devices';
    use HasFactory,SoftDeletes;
    protected $fillable = ['id', 'borrow_id', 'device_id','room_id','quantity','borrow_date','return_date','lecture_name','lesson_name','session','image_last','image_first','status','lecture_number'];
    public function borrow()
    {
        return $this->belongsTo(Borrow::class, 'borrow_id', 'id')->withoutTrashed();
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}