<?php
namespace App\Http\Controllers;

use App\Exports\Excel\BangDiemExport;
use App\Http\Controllers\Controller;
use App\Models\Diem;
use App\Models\LoaiDiem;
use App\Models\LopHoc;
use App\Models\MonHoc;
use Arr;
use Maatwebsite\Excel\Facades\Excel;
class ExcelExportBangDiem extends Controller
{
    public function exportBangDiemLop($mamonhoc, $malop, $hocky)
    {
        $monhoc = MonHoc::join('mon', 'monhoc.mamon', '=', 'mon.mamon')->where('mamonhoc', $mamonhoc)->get()->first();
        $danhsachlop = LopHoc::from('lophoc')
            ->join('hocsinh', 'hocsinh.mahocsinh', 'lophoc.mahocsinh')
            ->where('malop', $malop)->get();
        $dataloaidiem = LoaiDiem::whereIn('loaimon', [$monhoc->loaimon, 3])->orderBy('heso')->get();
        $data = [];
        foreach ($danhsachlop as $item => $hocsinh) {
            $danhsach = [];
            $danhsach = Arr::add($danhsach, count($danhsach), count($data) + 1);
            $danhsach = Arr::add($danhsach, count($danhsach), $hocsinh->hotenhocsinh);
            foreach ($dataloaidiem as $item => $loaidiem) {
                $diemhs = Diem::from('diem')
                    ->where('mahocsinh', $hocsinh->mahocsinh)
                    ->where('mamonhoc', $mamonhoc)
                    ->where('loaidiem', $loaidiem->maloaidiem)
                    ->where('hocky', $hocky)
                    ->get();
                $i = $loaidiem->soluong;
                $j = 0;
                echo "<script>console.log('soluong: ".$i."')</script>";
                foreach ($diemhs as $key => $value) {
                    $j++;
                    if ($monhoc->kieudiem == 0)
                        $danhsach = Arr::add($danhsach, count($danhsach), number_format((float) $value->diem, 2, '.', ''));
                    else
                        $danhsach = Arr::add($danhsach, count($danhsach), $value->diem == 'd' ? 'Đạt' : "Chưa đạt");
                }
                for ($e = $j; $e < $i; $e++) {
                    $danhsach = Arr::add($danhsach, count($danhsach), "");
                }

            }
            $tbm = Diem::tbm($hocsinh->mahocsinh, $mamonhoc, $hocky);
            $danhsach = Arr::add($danhsach, count($danhsach), $tbm);
            $data = Arr::add($data, count($data), $danhsach);
        }
        return Excel::download(new BangDiemExport($data, $monhoc->loaimon), $malop . ".xlsx");
    }
}
