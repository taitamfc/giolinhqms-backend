<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
    use HasFactory;
    protected $table = 'classify';
    function device(){
        return $this->hasMany(Device::class,'classify_id','id');
    }
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}