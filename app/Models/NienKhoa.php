<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NienKhoa extends Model
{
    use HasFactory;
    protected $table = "nienkhoa";
    protected $primaryKey = "manienkhoa";
    protected $fillable = ['manienkhoa','tennienkhoa','batdau','ketthuc','hk1','hk2'];

    public static function getAllNienKhoa()
    {
        $dsNienKhoa = NienKhoa::all();
        return $dsNienKhoa;
    }
    public $timestamps = false;
}
