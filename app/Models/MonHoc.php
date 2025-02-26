<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    use HasFactory;
    protected $table = "monhoc";
    protected $primaryKey = "mamonhoc";
    protected $fillable = ['mamonhoc','malop','macanbo','mamon'];

    public $timestamps = false;
}
