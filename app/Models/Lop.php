<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    use HasFactory;
    protected $table = "lop";
    protected $primaryKey = "malop";
    protected $keyType = 'string';
    protected $fillable = ['malop','tenlop','nienkhoa','chunhiem'];

    public static function getAllLop()
    {
        $dsLop = Lop::all();
        return $dsLop;
    }
    public $timestamps = false;
}
