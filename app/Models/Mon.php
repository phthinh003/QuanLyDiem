<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mon extends Model
{
    use HasFactory;
    protected $table = "mon";
    protected $primaryKey = "mamon";
    protected $keyType = 'string';
    protected $fillable = ['mamon','tenmon','loaimon'];

    public static function getAllMon()
    {
        $dsMon = Mon::all();
        return $dsMon;
    }
    public $timestamps = false;
}
