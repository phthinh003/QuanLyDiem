<?php
namespace App\Http\Controllers;

use App\Exports\Excel\BangDiemExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
class ExcelExportBangDiem extends Controller
{
    public function exportBangDiemLop()
    {
        $loaimon =
        $data = [
            [1, 'Trần Thiên Hương', 9.0, 9.0, 9.0, 9.0, 10.0, 7.0, 8.0, 8.6],
            // Thêm học sinh khác...
        ];

        return Excel::download(new BangDiemExport($data), 'bang_diem.xlsx');
    }
}
