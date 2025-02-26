<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiDiem extends Model
{
    use HasFactory;
    protected $table = "loaidiem";
    protected $primaryKey = "maloaidiem";
    protected $fillable = ['maloaidiem','tenloaidiem','heso','soluong','loaimon'];
    public $timestamps = false;
}
