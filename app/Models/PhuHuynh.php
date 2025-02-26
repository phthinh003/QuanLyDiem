<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuHuynh extends Model
{
    use HasFactory;
    protected $table = "phuhuynh";
    protected $primaryKey = "maphuhuynh";
    protected $keyType = 'string';
    protected $fillable =
        [
            'maphuhuynh',
            'tenphuhuynh',
            'gioitinh',
            'ngaysinh',
            'diachi',
            'sdt',
            'matkhau'
        ];

        //Lấy tất cả học sinh
        public static function getAll()
        {
            return PhuHuynh::all();
        }

        //Lấy thông tin phụ huynh với maphuhuynh
        public static function getByMaPhuHuynh($mph) {
            return PhuHuynh::where('maphuhuynh', $mph);
        }
        public $timestamps = false;
}
