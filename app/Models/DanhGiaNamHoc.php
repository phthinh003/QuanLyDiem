<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGiaNamHoc extends Model
{
    use HasFactory;

    protected $table = "danhgianamhoc";
    protected $fillable = [
        'mahocsinh',
        'manienkhoa',
        'tongnghi',
        'duoclenlop',
        'ccnpt',
        'xeploaicc',
        'giaithuong',
        'khenthuongdb',
        'nhanxet',
        'hk_hk1',
        'hk_hk2',
    ];

    protected $primaryKeys = ['mahocsinh', 'manienkhoa'];
    // Override method getKeyForSaveQuery (dùng khi update)
    protected function setKeysForSaveQuery($query)
    {
        foreach ($this->primaryKeys as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }

    public $timestamps = false;
}
