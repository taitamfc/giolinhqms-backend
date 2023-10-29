<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "rooms";
    protected $fillable = [
        'name',
        // các thuộc tính fillable khác
    ];
    public function borrows()
    {
        return $this->belongsToMany(Borrow::class,'borrow_devices','room_id','borrow_id');
    }
}
