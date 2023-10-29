<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
    use HasFactory;
    protected $table ='borrows';
    use HasFactory,SoftDeletes;
    protected $fillable = ['id', 'user_id', 'borrow_date','created_at','updated_at','deleted_at','borrow_note','status','approved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function the_devices()
    {
        return $this->hasMany(BorrowDevice::class, 'borrow_id', 'id');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class,'borrow_devices','borrow_id','device_id');
    }
    public function the_rooms()
    {
        return $this->belongsToMany(Room::class,'borrow_devices','borrow_id','room_id');
    }

}
