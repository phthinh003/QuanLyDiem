<?php

namespace App\Http\Controllers;

use App\Models\Diem;
use App\Models\HocSinh;
use App\Models\LoaiDiem;
use App\Models\Lop;
use App\Models\MonHoc;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DiemController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    // Show form: them, chinh sua diem
    public function edit($hocki, $mahocsinh, $mamonhoc)
    {
        $page_title = "Chỉnh sửa điểm";

        // Sidebar
        $macanbo=session('userid');
        $datalopchunhiem=Lop::from('lop')->where('chunhiem',$macanbo)->get();
        $datalopday=MonHoc::from('monhoc')
                                ->join('lop','lop.malop','monhoc.malop')
                                ->join('mon','monhoc.mamon','mon.mamon')
                                ->where('monhoc.macanbo',$macanbo)->get();

        // Noi dung phuong thuc chinh
        $monhoc = MonHoc::where('mamonhoc', $mamonhoc)
            ->join('mon', 'mon.mamon', 'monhoc.mamon')
            ->first();

        $datahocsinh = HocSinh::where('mahocsinh', $mahocsinh)->first();
        $datadiemhocsinh = Diem::where(['mahocsinh' => $mahocsinh, 'hocky'=> $hocki, 'mamonhoc' => $mamonhoc])->get();
        $dataloaidiem = LoaiDiem::whereIn('loaimon', [$monhoc->loaimon, 3])->orderBy('heso')->get();

        $datadiem_loaidiem = [];
        $diem = collect([]);
        foreach ($dataloaidiem as $key => $loaidiem) {
            // dd($datadiemhocsinh);
            $diem_loaidiem = $datadiemhocsinh
                ->where('loaidiem', $loaidiem->maloaidiem);

            $d = [];
            foreach ($diem_loaidiem as $key => $value) {
                $d = Arr::add($d, $value['madiem'], $value['diem']);
            }

            $i = count($d);
            for ($t = $i; $t < $loaidiem->soluong; $t++) {
                $d = Arr::add($d, 'new'.'_'.$loaidiem->maloaidiem.'_'.$t-$i, "");
            }

            $dtam = Arr::add($loaidiem->toArray(), 'diem', $d);

            $diem = Arr::add($diem, count($diem), $dtam);
        }

        return view('pages.danhmuc.diem.edit', compact('page_title', 'diem', 'hocki', 'datahocsinh', 'monhoc', 'datalopchunhiem', 'datalopday'));
    }

    // Cap nhat du lieu diem vao csdl
    public function update(Request $request)
    {
        // Lay du lieu can thiet (du lieu khong phai diem)
        $mahocsinh = $request->mahocsinh;
        $mamonhoc = $request->mamonhoc;
        $hocki = $request->hocki;

        // Gan mang - loai bo du lieu da lay (du lieu con lai la du lieu diem)
        $datas = Arr::except($request->toArray(), ['_token', '_method', 'mahocsinh', 'mamonhoc', 'hocki','btn_summit']);
        // dd($datas);
        foreach ($datas as $key => $data) {
            if (strpos($key, 'new')!==false) {
                if ($data==null) continue;
                else {
                    // Lay loai diem $key vd: new_2_1
                    $loaidiem = substr($key, strpos($key, '_')+1, strrpos($key, '_')-strpos($key, '_')-1);

                    // Tao doi tuong diem
                    $diem = new Diem();
                    $diem->mahocsinh = $mahocsinh;
                    $diem->mamonhoc = $mamonhoc;
                    $diem->hocky = $hocki;
                    $diem->diem = $data;
                    $diem->loaidiem = $loaidiem;

                    $diem->save();
                }
            } else {
                $diem = Diem::find($key, 'madiem');
                // dd($diem);
                $diem->diem = $data;

                $diem->save();
            }
        }

        // Lay du lieu tra ve trang diem
        return redirect()->route('canboManage.danhsachlopday', [$mamonhoc, $hocki]);
    }

    public function delete($madiem)
    {
        //
    }
}
