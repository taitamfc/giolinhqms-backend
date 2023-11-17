<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "departments";
    protected $fillable = [
        'name',
        // các thuộc tính fillable khác
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}