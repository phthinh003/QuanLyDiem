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

    public static function tbm($mahocsinh, $mamonhoc, $hocky)
    {
        $monhoc = MonHoc::where('mamonhoc', '=', $mamonhoc)->firstOr();
        $mon = Mon::where('mamon', '=', $monhoc->mamon)->firstOr();
        $diemhs = Diem::from('diem')
            ->join('loaidiem', 'maloaidiem', '=', 'loaidiem')
            ->where('mahocsinh', $mahocsinh)
            ->where('mamonhoc', $mamonhoc)
            ->where('hocky', $hocky)
            ->get();

        if ($diemhs->count() == 0)
            $tbm = "";
        else {
            if ($mon->kieudiem == 0) {
                // Điểm số
                $tongdiem = 0;
                $heso = 0;
                // Tổng điểm (tổng diem[i]*heso[i])
                foreach ($diemhs as $diem) {
                    $tongdiem += $diem->diem * $diem->heso;
                    $heso += $diem->heso;
                }

                $tbm = number_format($tongdiem / $heso, 1, '.');
            } else {
                // Điểm đánh giá
                $tbm = "Đạt";
                foreach ($diemhs as $diem) {
                    if ($diem->diem == 'cd') {
                        $tbm = "Chưa đạt";
                        break;
                    }
                }
            }
        }
        // dd($diemhs);
        return $tbm;
    }
}
