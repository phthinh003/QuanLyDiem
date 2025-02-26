<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    use HasFactory;
    protected $table = "lophoc";
    protected $primaryKey = "malophoc";
    protected $fillable = ['malophoc','malop','mahocsinh'];
    public $timestamps = false;
}
