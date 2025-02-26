<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diem extends Model
{
    use HasFactory;
    protected $table = "diem";
    protected $primaryKey = "madiem";
    protected $keyType = 'int';
    protected $fillable = [
        'madiem',
        'mahocsinh',
        'mamonhoc',
        'hocky',
        'diem',
        'loaidiem',
    ];
    public $timestamps = false;
}
