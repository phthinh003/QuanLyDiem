<?php

namespace App\Http\Controllers;

use App\Models\Diem;
use App\Models\HocSinh;
use App\Models\LoaiDiem;
use App\Models\Lop;
use App\Models\LopHoc;
use App\Models\MonHoc;
use App\Models\Mon;
use App\Models\PhuHuynh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Psy\Readline\Hoa\Console;

class DanhSachController extends Controller
{
    public function danhsachlopday($mamonhoc, $hocki)
    {
        $page_title = "Danh sách lớp ";

        $monhoc = Monhoc::select('monhoc.*', 'mon.loaimon', 'mon.kieudiem')
            ->join('mon', 'mon.mamon', 'monhoc.mamon')
            ->where('mamonhoc', $mamonhoc)->first();

        $malop = $monhoc->malop;
        $nowdate = Carbon::now();
        //du lieu cho sidebar
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

        // du lieu noi dung
        $danhsachlop = LopHoc::from('lophoc')
            ->join('hocsinh', 'hocsinh.mahocsinh', 'lophoc.mahocsinh')
            ->where('malop', $malop)->get();
        $tt = Monhoc::from('monhoc')->join('canbo', 'monhoc.macanbo', 'canbo.macanbo')
            ->join('mon', 'mon.mamon', 'monhoc.mamon')
            ->join('lop', 'lop.malop', 'monhoc.malop')
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')
            ->where('mamonhoc', $mamonhoc)->first();
        $thongtinlop =
            [
                'mamon' => $tt->mamon,
                'kieudiem' => $tt->kieudiem,
                'malop' => $tt->malop,
                'tenlop' => $tt->tenlop,
                'canbo' => $tt->hoten,
                'mon' => $tt->tenmon,
                'siso' => count($danhsachlop),
                'nienkhoa' => $tt->tennienkhoa
            ];
        $filename = 'Điểm_' . $tt->tenlop . '_' . ($hocki < 3 ? 'hk' . $hocki : 'canam') . '_' . $tt->tennienkhoa;
        $dataloaidiem = LoaiDiem::whereIn('loaimon', [$monhoc->loaimon, 3])->orderBy('heso')->get();
        $danhsach = [];
        foreach ($danhsachlop as $item => $hocsinh) {
            $d = [];
            // dd($dataloaidiem);
            foreach ($dataloaidiem as $item => $loaidiem) {
                $diemhs = Diem::from('diem')
                    ->where('mahocsinh', $hocsinh->mahocsinh)
                    ->where('mamonhoc', $mamonhoc)
                    ->where('loaidiem', $loaidiem->maloaidiem)
                    ->where('hocky', $hocki)
                    ->get();
                $i = $loaidiem->soluong;
                $j = 0;
                foreach ($diemhs as $item => $diem) {
                    $d = Arr::add($d, $diem->madiem, $monhoc->kieudiem == 0 ? number_format((float) $diem->diem, 2, '.', '') : $diem->diem);
                    $j++;
                }
                for ($e = $j; $e < $i; $e++) {
                    // echo "<script>console.log('".'new_' . $loaidiem->maloaidiem . '_' . $e-$j+1 ."'".")</script>";
                    $d = Arr::add($d, $hocsinh->mahocsinh . '_' . $loaidiem->maloaidiem . '_' . $e - $j + 1, "");
                }
            }

            $tbm = Diem::tbm($hocsinh->mahocsinh, $mamonhoc, $hocki);

            $danhsach = Arr::add($danhsach, count($danhsach), ['mahocsinh' => $hocsinh->mahocsinh, 'tenhocsinh' => $hocsinh->hotenhocsinh, 'diem' => $d, 'tbm' => $tbm]);
            // dd($danhsach);
        }
        // Khoa diem
        $date1 = Date::now();
        $khoadiem = false;
        if ($hocki == 1) {
            if ($date1 > $tt->hk1) $khoadiem = true;
        } elseif ($hocki == 2) {
            if ($date1 > $tt->hk2) $khoadiem = true;
        }
        session()->put('khoadiem', $khoadiem);
        // dd($khoadiem);
        return view('pages.canbo.giaovien.danhsachlopday', compact('page_title', 'datalopchunhiem', 'datalopday', 'dataloaidiem', 'danhsach', 'mamonhoc', 'hocki', 'thongtinlop', 'filename', 'khoadiem'));
    }
    public function bangdiemcanamlopday($mamonhoc)
    {
        $page_title = "Danh sách lớp ";

        $monhoc = Monhoc::select('monhoc.*', 'mon.loaimon')
            ->join('mon', 'mon.mamon', 'monhoc.mamon')
            ->where('mamonhoc', $mamonhoc)->first();

        $malop = $monhoc->malop;
        $nowdate = Carbon::now();
        //du lieu cho sidebar
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

        // du lieu noi dung
        $danhsachlop = LopHoc::from('lophoc')
            ->join('hocsinh', 'hocsinh.mahocsinh', 'lophoc.mahocsinh')
            ->where('malop', $malop)->get();
        $tt = Monhoc::from('monhoc')->join('canbo', 'monhoc.macanbo', 'canbo.macanbo')
            ->join('mon', 'mon.mamon', 'monhoc.mamon')
            ->join('lop', 'lop.malop', 'monhoc.malop')
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')
            ->where('mamonhoc', $mamonhoc)->first();
        $thongtinlop =
            [
                'mamonhoc' => $tt->mamonhoc,
                'kieudiem' => $tt->kieudiem,
                'malop' => $tt->malop,
                'tenlop' => $tt->tenlop,
                'canbo' => $tt->hoten,
                'mon' => $tt->tenmon,
                'siso' => count($danhsachlop),
                'nienkhoa' => $tt->tennienkhoa
            ];
        $filename = 'Điểm_' . $tt->tenlop . '_' . ('canam') . '_' . $tt->tennienkhoa;
        $dataloaidiem = LoaiDiem::whereIn('loaimon', [$monhoc->loaimon, 3])->orderBy('heso')->get();
        $danhsach = [];
        foreach ($danhsachlop as $item => $hocsinh) {
            $tbm_hk1 = Diem::tbm($hocsinh->mahocsinh, $mamonhoc, 1);
            $tbm_hk2 = Diem::tbm($hocsinh->mahocsinh, $mamonhoc, 2);
            if ($tbm_hk1 == "" || $tbm_hk2 == "") {
                $tbm = "";
            } else {
                if ($tt->kieudiem == 0) {
                    $tbm = ($tbm_hk1 + 2 * $tbm_hk2) / 3;
                    $tbm = number_format($tbm, 1, '.', '');
                } else {
                    $tbm = $tbm_hk2 == 'Đạt' ? "Đạt" : "Chưa Đạt";
                }
            }

            $danhsach = Arr::add($danhsach, count($danhsach), ['mahocsinh' => $hocsinh->mahocsinh, 'tenhocsinh' => $hocsinh->hotenhocsinh, 'diem' => ['hocki1' => $tbm_hk1, 'hocki2' => $tbm_hk2], 'tbm' => $tbm]);
            // dd($danhsach);
        }
        $dataloaidiem = [];
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Học Kì 1";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Học Kì 2";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Cả Năm";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $hocki = 3;
        // dd($danhsach);
        $khoadiem = true;

        return view('pages.canbo.giaovien.danhsachlopday', compact('page_title', 'datalopchunhiem', 'datalopday', 'dataloaidiem', 'danhsach', 'mamonhoc', 'hocki', 'thongtinlop', 'filename', 'khoadiem'));
    }
    public function danhsachlopchunhiem($malop, $hocki)
    {
        $page_title = "Danh sách lớp ";

        $nowdate = Carbon::now();
        //du lieu cho sidebar
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
        //du lieu hien thi noi dung
        $danhsachlop = LopHoc::from('lophoc')
            ->join('hocsinh', 'lophoc.mahocsinh', 'hocsinh.mahocsinh')
            ->join('lop', 'lop.malop', 'lophoc.malop')
            ->where('lop.chunhiem', $macanbo)
            ->where('lop.malop', $malop)
            ->select('hocsinh.mahocsinh', 'lop.malop', 'hotenhocsinh')
            ->get();
        $datamon = MonHoc::from('monhoc')
            ->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->where('malop', $malop)->get();

        $lop = Lop::from('lop')
            ->join('canbo', 'lop.chunhiem', 'canbo.macanbo')
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')
            ->where('malop', $malop)->first();
        // ->where("chunhiem",$macanbo)->first();
        // dd($lop);
        $thongtinlop = [];
        $thongtinlop = Arr::add(
            $thongtinlop,
            count($thongtinlop),
            [
                'Tên lớp' => $lop->tenlop,
                'Giáo viên chủ nhiệm' => $lop->hoten,
                'Sỉ số' => count($danhsachlop),
                'Niên khóa' => $lop->tennienkhoa,
            ]
        );
        $dataloaidiem = LoaiDiem::orderBy('heso')->get();
        $danhsach = [];
        foreach ($danhsachlop as $item => $hocsinh) {
            $d = [];
            $tong = 0;
            // dd($dataloaidiem);
            foreach ($datamon as $kmon => $mon) {
                $tbm = Diem::tbm($hocsinh->mahocsinh, $mon->mamonhoc, $hocki);
                if ($tbm != '' && $mon->kieudiem == 0) $tong += $tbm;
                $d = Arr::add($d, $mon->mamon, $tbm);
            }
            $sldiem = count(array_filter($d, function ($value) {
                return $value != "Đạt" && $value != "Chưa đạt" && $value != '';
            }));
            if ($sldiem != 0) {
                $tb = $tong / $sldiem;
                $tb = round($tb, 2);
            } else
                $tb = "";

            $danhsach = Arr::add($danhsach, count($danhsach), ['mahocsinh' => $hocsinh->mahocsinh, 'tenhocsinh' => $hocsinh->hotenhocsinh, 'diem' => $d, 'tb' => $tb]);
        }
        // dd($danhsach);
        return view('pages.canbo.giaovien.danhsachlopchunhiem', compact('page_title', 'datalopchunhiem', 'datalopday', 'datamon', 'danhsachlop', 'danhsach', 'malop', 'thongtinlop', 'hocki'));
    }
    public function bangdiemcanamlopchunhiem($malop)
    {
        $page_title = "Danh sách lớp ";

        $nowdate = Carbon::now();
        //du lieu cho sidebar
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
        //du lieu hien thi noi dung
        $danhsachlop = LopHoc::from('lophoc')
            ->join('hocsinh', 'lophoc.mahocsinh', 'hocsinh.mahocsinh')
            ->join('lop', 'lop.malop', 'lophoc.malop')
            ->where('lop.malop', $malop)
            ->where('lop.chunhiem', $macanbo)
            ->select('hocsinh.mahocsinh', 'lop.malop', 'hotenhocsinh')
            ->get();
        $datamon = MonHoc::from('monhoc')
            ->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->where('malop', $malop)->get();
        $lop = Lop::from('lop')
            ->join('canbo', 'lop.chunhiem', 'canbo.macanbo')
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')
            ->where('malop', $malop)->first();
        $thongtinlop = [];
        $thongtinlop = Arr::add(
            $thongtinlop,
            count($thongtinlop),
            [
                'Tên lớp' => $lop->tenlop,
                'Giáo viên chủ nhiệm' => $lop->hoten,
                'Sỉ số' => count($danhsachlop),
                'Niên khóa' => $lop->tennienkhoa
            ]
        );
        $danhsach = [];
        foreach ($danhsachlop as $item => $hocsinh) {
            $d = [];
            $sldiem = 0;
            $tb = 0;
            // dd($dataloaidiem);
            foreach ($datamon as $kmon => $mon) {

                $tbm1 = Diem::tbm($hocsinh->mahocsinh, $mon->mamonhoc, 1);
                $tbm2 = Diem::tbm($hocsinh->mahocsinh, $mon->mamonhoc, 2);

                if ($tbm1 == "" || $tbm2 == "") {
                    $tbm = "";
                } else {
                    if ($mon->kieudiem == 0) {
                        $tbm = ($tbm1 + 2 * $tbm2) / 3;
                        $sldiem++;
                        $tbm = number_format($tbm, 1, '.', '');
                        $tb += $tbm;
                    } else {
                        $tbm = $tbm2;
                    }
                }
                $d = Arr::add($d, $mon->mamon, $tbm);
            }
            if ($sldiem != 0)
                $tb /= $sldiem;
            else
                $tb = "";

            $danhsach = Arr::add($danhsach, count($danhsach), ['mahocsinh' => $hocsinh->mahocsinh, 'tenhocsinh' => $hocsinh->hotenhocsinh, 'diem' => $d, 'tb' => $tb]);
        }
        // dd($danhsach);
        $hocki = 3;
        return view('pages.canbo.giaovien.danhsachlopchunhiem', compact('page_title', 'datalopchunhiem', 'datalopday', 'datamon', 'danhsachlop', 'danhsach', 'malop', 'thongtinlop', 'hocki'));
    }

    public function diemhocsinh($malop, $hocki)
    {
        $page_title = "Bảng điểm cá nhân";
        $mahocsinh = session('userid');
        $hs = Hocsinh::find($mahocsinh);
        $lop = Lop::where('malop', $malop)
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')->first();
        $thongtinhs = [];
        $thongtinhs = Arr::add($thongtinhs, count($thongtinhs), ['Họ và tên' => $hs->hotenhocsinh, 'Lớp' => $lop->tenlop, 'Niên khóa' => $lop->tennienkhoa]);
        // dd($thongtinhs);
        //du lieu sidebar
        $datalop = LopHoc::join('lop', 'lophoc.malop', 'lop.malop')
            ->join('canbo', 'canbo.macanbo', 'lop.chunhiem')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->where('mahocsinh', $mahocsinh)->get();
        //du lieu noi dung
        $dataloaidiem = LoaiDiem::orderBy('heso')->get();
        $dsmon = MonHoc::from('monhoc')->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->where('malop', $malop)->get();
        $danhsach = [];
        foreach ($dsmon as $item => $mon) {
            $d = [];
            $tongdiem = 0;
            $tonghesodiem = 0;
            // dd($dataloaidiem);
            foreach ($dataloaidiem as $item => $loaidiem) {
                $diemhs = Diem::from('diem')
                    ->where('mahocsinh', $mahocsinh)
                    ->where('mamonhoc', $mon->mamonhoc)
                    ->where('loaidiem', $loaidiem->maloaidiem)
                    ->where('hocky', $hocki)
                    ->get();
                $i = $loaidiem->soluong;
                $j = 0;
                foreach ($diemhs as $item => $diem) {
                    if ($mon->kieudiem == 0)
                        $d = Arr::add($d, $diem->loaidiem . '_' . $j, $diem->diem);
                    else {
                        // dd($diem);
                        if ($diem->diem == "d") $d = Arr::add($d, $diem->loaidiem . '_' . $j, "Đạt");
                        else $d = Arr::add($d, $diem->loaidiem . '_' . $j, "Chưa Đạt");
                    }
                    $j++;
                }
                if ($j != 0)
                    $j--;
                for ($e = $j; $e < $i; $e++) {
                    $d = Arr::add($d, $loaidiem->maloaidiem . '_' . $e, "");
                }
            }
            $tbm = Diem::tbm($mahocsinh, $mon->mamonhoc, $hocki);

            $danhsach = Arr::add($danhsach, count($danhsach), ['tenmon' => $mon->tenmon, 'diem' => $d, 'tbm' => $tbm]);
        }
        // dd($danhsach);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "TBM";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        return view('pages.hocsinh.diem', compact('page_title', 'datalop', 'dataloaidiem', 'danhsach', 'malop', 'thongtinhs'));
    }
    public function getDiemCaNamHS($malop)
    {
        $page_title = "Bảng điểm cá nhân";
        $mahocsinh = session('userid');
        $hs = Hocsinh::find($mahocsinh);
        $lop = Lop::where('malop', $malop)
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')->first();
        $thongtinhs = [];
        $thongtinhs = Arr::add($thongtinhs, count($thongtinhs), ['Họ và tên' => $hs->hotenhocsinh, 'Lớp' => $lop->tenlop, 'Niên khóa' => $lop->tennienkhoa]);
        //du lieu sidebar
        $datalop = LopHoc::join('lop', 'lophoc.malop', 'lop.malop')
            ->where('mahocsinh', $mahocsinh)->get();
        //du lieu noi dung
        $dataloaidiem = LoaiDiem::orderBy('heso')->get();
        $dsmon = MonHoc::from('monhoc')->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->where('malop', $malop)->get();
        $danhsach = [];
        foreach ($dsmon as $item => $mon) {
            $tbm1 = Diem::tbm($mahocsinh, $mon->mamonhoc, 1);
            $tbm2 = Diem::tbm($mahocsinh, $mon->mamonhoc, 2);
            if ($tbm1 == "" || $tbm2 == "") {
                $tbcm = "";
            } else {
                if ($mon->kieudiem == 0) {
                    $tbm = ($tbm1 + 2 * $tbm2) / 3;
                    $tbcm = number_format($tbm, 1, '.', '');
                } else {
                    $tbcm = $tbm2;
                }
            }
            $danhsach = Arr::add($danhsach, count($danhsach), ['tenmon' => $mon->tenmon, 'hocki1' => $tbm1, 'hocki2' => $tbm2, 'canam' => $tbcm]);
        }
        $dataloaidiem = [];
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Học Kì 1";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Học Kì 2";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Cả Năm";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        // dd($dataloaidiem);

        return view('pages.hocsinh.diem', compact('page_title', 'datalop', 'dataloaidiem', 'danhsach', 'malop', 'thongtinhs'));
    }
    public function diemhocsinhPH($mahocsinh, $malop, $hocki)
    {
        $page_title = "Bảng điểm cá nhân";
        $hs = Hocsinh::find($mahocsinh);
        $lop = Lop::where('malop', $malop)
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')->first();
        $thongtinhs = [];
        $thongtinhs = Arr::add($thongtinhs, count($thongtinhs), ['Họ và tên' => $hs->hotenhocsinh, 'Lớp' => $lop->tenlop, 'Niên khóa' => $lop->tennienkhoa]);
        // dd($thongtinhs);

        //du lieu sidebar
        $maphuhuynh = session('userid');
        $phuhuynh = PhuHuynh::find($maphuhuynh);
        $dshs = HocSinh::where('maphuhuynh', $maphuhuynh)->get();
        $menu = [];
        foreach ($dshs as $key => $hocsinh) {
            $lop = [];
            $lophoc = LopHoc::join('lop', 'lop.malop', 'lophoc.malop')
                ->where('mahocsinh', $hocsinh->mahocsinh)->get();
            foreach ($lophoc as $k => $value) {
                $lop = Arr::add($lop, count($lop), [$value]);
            }
            $menu = Arr::add($menu, count($menu), ['hocsinh' => $hocsinh, 'lop' => $lop]);
        }

        //du lieu noi dung
        $dataloaidiem = LoaiDiem::orderBy('heso')->get();
        $dsmon = MonHoc::from('monhoc')->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->where('malop', $malop)->get();
        $danhsach = [];
        foreach ($dsmon as $item => $mon) {
            $d = [];
            $tongdiem = 0;
            $tonghesodiem = 0;
            // dd($dataloaidiem);
            foreach ($dataloaidiem as $item => $loaidiem) {
                $diemhs = Diem::from('diem')
                    ->where('mahocsinh', $mahocsinh)
                    ->where('mamonhoc', $mon->mamonhoc)
                    ->where('loaidiem', $loaidiem->maloaidiem)
                    ->where('hocky', $hocki)
                    ->get();
                $i = $loaidiem->soluong;
                $j = 0;
                foreach ($diemhs as $item => $diem) {
                    $d = Arr::add($d, $diem->loaidiem . '_' . $j, $diem->diem);
                    $j++;
                    $tongdiem += $loaidiem->heso * $diem->diem;
                    $tonghesodiem += (int) $loaidiem->heso;
                }
                if ($j != 0)
                    $j--;
                for ($e = $j; $e < $i; $e++) {
                    $d = Arr::add($d, $loaidiem->maloaidiem . '_' . $e, "");
                }
            }
            if ($tonghesodiem != 0) {
                $tbm = $tongdiem / $tonghesodiem;
            } else {
                $tbm = "";
            }
            $danhsach = Arr::add($danhsach, count($danhsach), ['tenmon' => $mon->tenmon, 'diem' => $d, 'tbm' => $tbm]);
        }
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "TBM";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        return view('pages.phuhuynh.diem', compact('page_title', 'menu', 'dataloaidiem', 'danhsach', 'malop', 'thongtinhs', 'mahocsinh'));
    }
    public function getDiemCaNamHSPH($mahocsinh, $malop)
    {
        $page_title = "Bảng điểm cá nhân";
        // $mahocsinh = session('userid');
        $hs = Hocsinh::find($mahocsinh);
        $lop = Lop::where('malop', $malop)
            ->join('nienkhoa', 'lop.nienkhoa', 'nienkhoa.manienkhoa')->first();
        $thongtinhs = [];
        $thongtinhs = Arr::add($thongtinhs, count($thongtinhs), ['Họ và tên' => $hs->hotenhocsinh, 'Lớp' => $lop->tenlop, 'Niên khóa' => $lop->tennienkhoa]);
        //du lieu sidebar
        $maphuhuynh = session('userid');
        $phuhuynh = PhuHuynh::find($maphuhuynh);
        $dshs = HocSinh::where('maphuhuynh', $maphuhuynh)->get();
        $menu = [];
        // dd($dshs);
        foreach ($dshs as $key => $hocsinh) {
            $lop = [];
            $lophoc = LopHoc::join('lop', 'lop.malop', 'lophoc.malop')
                ->where('mahocsinh', $hocsinh->mahocsinh)->get();
            foreach ($lophoc as $k => $value) {
                $lop = Arr::add($lop, count($lop), [$value]);
            }
            $menu = Arr::add($menu, count($menu), ['hocsinh' => $hocsinh, 'lop' => $lop]);
        }
        //du lieu noi dung
        $dataloaidiem = LoaiDiem::orderBy('heso')->get();
        $dsmon = MonHoc::from('monhoc')->join('mon', 'monhoc.mamon', 'mon.mamon')
            ->where('malop', $malop)->get();
        $danhsach = [];
        foreach ($dsmon as $item => $mon) {
            $tongdiem = 0;
            $tonghesodiem = 0;
            // dd($dataloaidiem);
            foreach ($dataloaidiem as $item => $loaidiem) {
                $diemhs = Diem::from('diem')
                    ->where('mahocsinh', $mahocsinh)
                    ->where('mamonhoc', $mon->mamonhoc)
                    ->where('loaidiem', $loaidiem->maloaidiem)
                    ->where('hocky', 1)
                    ->get();
                foreach ($diemhs as $item => $diem) {
                    $tongdiem += $loaidiem->heso * $diem->diem;
                    $tonghesodiem += (int) $loaidiem->heso;
                }
            }
            if ($tonghesodiem != 0) {
                $tbm1 = $tongdiem / $tonghesodiem;
            } else {
                $tbm1 = "";
            };
            $tongdiem = 0;
            $tonghesodiem = 0;
            foreach ($dataloaidiem as $item => $loaidiem) {
                $diemhs = Diem::from('diem')
                    ->where('mahocsinh', $mahocsinh)
                    ->where('mamonhoc', $mon->mamonhoc)
                    ->where('loaidiem', $loaidiem->maloaidiem)
                    ->where('hocky', 2)
                    ->get();
                $i = $loaidiem->soluong;
                $j = 0;
                foreach ($diemhs as $item => $diem) {
                    $j++;
                    $tongdiem += $loaidiem->heso * $diem->diem;
                    $tonghesodiem += (int) $loaidiem->heso;
                }
                if ($j != 0)
                    $j--;
            }
            if ($tonghesodiem != 0) {
                $tbm2 = $tongdiem / $tonghesodiem;
            } else {
                $tbm2 = "";
            };
            if ($tbm1 == "" || $tbm2 == "") {
                $tbcm = "";
            } else
                $tbcm = ($tbm1 + 2 * $tbm2) / '3';
            $danhsach = Arr::add($danhsach, count($danhsach), ['tenmon' => $mon->tenmon, 'hocki1' => $tbm1, 'hocki2' => $tbm2, 'canam' => $tbcm]);
        }
        $dataloaidiem = [];
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Học Kì 1";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Học Kì 2";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        $loaidiem = new LoaiDiem();
        $loaidiem->tenloaidiem = "Cả Năm";
        $loaidiem->soluong = 1;
        $dataloaidiem = Arr::add($dataloaidiem, count($dataloaidiem), $loaidiem);
        // dd($dataloaidiem);

        return view('pages.phuhuynh.diem', compact('page_title', 'menu', 'dataloaidiem', 'danhsach', 'malop', 'thongtinhs', 'mahocsinh'));
    }
}
