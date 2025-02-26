<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HocSinh extends Model
{
    use HasFactory;
    protected $table = "hocsinh";
    protected $primaryKey = "mahocsinh";
    protected $keyType = 'string';
    protected $fillable =
        [
            'mahocsinh',
            'maphuhuynh',
            'hotenhocsinh',
            'gioitinh',
            'ngaysinh',
            'diachi',
            'sdt',
            'matkhau'
        ];

        //Lấy tất cả học sinh
        public static function getAll()
        {
            return HocSinh::all();
        }

        //Lấy thông tin học sinh với mahocsinh
        public static function getByMaHocSinh($mph) {
            return PhuHuynh::where('mahocsinh', $mph);
        }
        public $timestamps = false;
}
