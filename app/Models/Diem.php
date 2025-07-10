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

    public static function tbm($mahocsinh, $mamonhoc, $hocky) {
        $diemhs = Diem::from('diem')
                    ->join('loaidiem', 'maloaidiem', '=', 'loaidiem')
                    ->where('mahocsinh',  $mahocsinh)
                    ->where('mamonhoc',  $mamonhoc)
                    ->where('hocky' ,  $hocky)
                    ->get();
        // Tổng điểm (tổng diem[i]*heso[i])
        $tongdiem = 0;
        $heso = 0;
        foreach ($diemhs as $diem) {
            $tongdiem += $diem->diem * $diem->heso;
            $heso += $diem->heso;
        }

        $tbm = number_format($tongdiem/$heso, 1, '.');
        return $tbm;
    }
}
