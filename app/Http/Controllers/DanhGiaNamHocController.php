<?php

namespace App\Http\Controllers;

use App\Models\DanhGiaNamHoc;
use App\Models\HocSinh;
use App\Models\Diem;
use App\Models\Lop;
use App\Models\LopHoc;
use App\Models\MonHoc;
use App\Models\PhuHuynh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DanhGiaNamHocController extends Controller
{
    public function index($malop)
    {
        $page_title = "Danh sách lớp ";

        //du lieu cho sidebar
        $nowdate = Carbon::now();
        $macanbo = session('userid');
        $datalopchunhiem = Lop::from('lop')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->where('chunhiem', $macanbo)
            ->where('ketthuc', '>', $nowdate)
            ->get();
        $datalopday = MonHoc::from('monhoc')
            ->join('lop', 'lop.malop', 'monhoc.malop')
            ->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->where('monhoc.macanbo', $macanbo)
            ->where('ketthuc', '>', $nowdate)
            ->get();

        $danhsachlop = LopHoc::join('hocsinh', 'lophoc.mahocsinh', 'hocsinh.mahocsinh')
            ->join('lop', 'lop.malop', 'lophoc.malop')
            ->where('lop.chunhiem', $macanbo)
            ->where('lop.malop', $malop)
            ->select('hocsinh.mahocsinh', 'lop.malop', 'hotenhocsinh')
            ->get();

        $lop = Lop::from('lop')
            ->join('canbo', 'lop.chunhiem', 'canbo.macanbo')
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')
            ->where('malop', $malop)->first();

        $thongtinlop =
            [
                'Mã lớp' => $lop->malop,
                'Tên lớp' => $lop->tenlop,
                'Giáo viên chủ nhiệm' => $lop->hoten,
                'Sỉ số' => count($danhsachlop),
                'Niên khóa' => $lop->tennienkhoa,
            ];
        // dd($danhsachlop);
        return view('pages.danhmuc.danhgianamhoc.danhsach', compact('page_title', 'datalopchunhiem', 'datalopday', 'thongtinlop', 'malop', 'danhsachlop'));
    }

    public function create($malop, $mahocsinh)
    {
        $page_title = "Đánh giá học sinh ";

        //du lieu cho sidebar
        $nowdate = Carbon::now();
        $macanbo = session('userid');
        $datalopchunhiem = Lop::from('lop')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->where('chunhiem', $macanbo)
            ->where('ketthuc', '>', $nowdate)
            ->get();
        $datalopday = MonHoc::from('monhoc')
            ->join('lop', 'lop.malop', 'monhoc.malop')
            ->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->where('monhoc.macanbo', $macanbo)
            ->where('ketthuc', '>', $nowdate)
            ->get();
        // ------------------------------------------------------------

        $data = LopHoc::join('lop', 'lop.malop', 'lophoc.malop')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->join('hocsinh', 'hocsinh.mahocsinh', 'lophoc.mahocsinh')
            ->where('lophoc.mahocsinh', $mahocsinh)
            ->where('lophoc.malop', $malop)
            ->select(['lophoc.mahocsinh', 'lophoc.malop', 'lop.nienkhoa', 'hocsinh.hotenhocsinh', 'tenlop', 'tennienkhoa'])
            ->get()[0];
        // dd($data);
        $danhgia = DanhGiaNamHoc::where('mahocsinh', $data->mahocsinh)
            ->where('manienkhoa', $data->nienkhoa)
            ->get()->first();
        if ($danhgia->toArray() == null) {
            return view('pages.danhmuc.danhgianamhoc.danhgia', compact('page_title', 'datalopchunhiem', 'datalopday', 'data'));
        } else {
            return view('pages.danhmuc.danhgianamhoc.chinhsuadanhgia', compact('page_title', 'datalopchunhiem', 'datalopday', 'data', 'danhgia'));
        }
    }

    public function store(Request $request)
    {
        $check = DanhGiaNamHoc::where('mahocsinh', $request->mahocsinh)
                ->where('manienkhoa', $request->manienkhoa)
                ->get();
        if (count($check->toArray()) == 0) {
            $danhgia = new DanhGiaNamHoc();
            $danhgia->fill($request->toArray());
            $danhgia->xacnhancualanhdao = 0;
            $danhgia->save();
        } else {
            $danhgia = $check[0];
            $danhgia->fill($request->toArray());

            dd($danhgia);
            $danhgia->xacnhancualanhdao = 0;
            $danhgia->save();
        }
        return redirect()->route('canboManage.danhsachDanhGia', [$request->malop]);
    }
}
