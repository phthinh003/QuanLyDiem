<?php

namespace App\Http\Controllers;

use App\Models\CanBo;
use App\Models\Lop;
use App\Models\Mon;
use App\Models\MonHoc;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MonHocController extends Controller
{
    public function index()
    {
        $page_title = "Phân công";
        $data = MonHoc::from('monhoc')
            ->join('canbo','canbo.macanbo','monhoc.macanbo')
            ->join('mon','mon.mamon','monhoc.mamon')
            ->join('lop','lop.malop','monhoc.malop')->get();
        confirmDelete("", "");
        return view('pages.phanconggiangday.indexmonhoc', compact('page_title', 'data'));
    }
    public function create()
    {
        $page_title = "Tạo mới";
        $datacanbo=CanBo::from('canbo')->where('macanbo','LIKE','CB%')->get();
        $datamon=Mon::all();
        $datalop=Lop::from('lop')->join('nienkhoa','lop.nienkhoa','nienkhoa.manienkhoa')->get();

        return view('pages.phanconggiangday.createmonhoc', compact('page_title','datacanbo','datamon','datalop'));
    }
    public function store(Request $request)
    {
        try {
            // Kiem tra mon cua lop co duoc day chua
            $dieu_kien = ['malop' => $request->malop, 'mamon' => $request->mamon];
            $check_exist = MonHoc::where($dieu_kien)->get()->first();
            if (!is_null($check_exist)) {
                return redirect()->back()
                    ->withErrors(['da_duoc_phan_cong' => 'Môn này đã được cán bộ khác giảng dạy.'])
                    ->withInput();
            }

            $monhoc = new MonHoc();
            $monhoc->fill($request->toArray());

            $monhoc->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới thành công!', 'Thành công!');

            return redirect()->route('monhocManage.indexMonHoc');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit($id)
    {
        $page_title = "Chỉnh Sửa Thông Tin Giảng Dạy";
        $info = MonHoc::find($id);
        $datacanbo=CanBo::from('canbo')->where('macanbo','LIKE','CB%')->get();
        $datamon=Mon::all();
        $datalop=Lop::from('lop')->join('nienkhoa','lop.nienkhoa','nienkhoa.manienkhoa')->get();
        return view('pages.phanconggiangday.editmonhoc', compact('page_title', 'info','datacanbo','datalop','datamon'));
    }

    public function update(Request $request)
    {
        try {
            // Kiem tra mon cua lop co duoc day chua
            $dieu_kien = ['malop' => $request->malop, 'mamon' => $request->mamon];
            $check_exist = MonHoc::where($dieu_kien)->get()->first();
            if (!is_null($check_exist)) {
                return redirect()->back()
                    ->withErrors(['da_duoc_phan_cong' => 'Môn này đã được cán bộ khác giảng dạy.'])
                    ->withInput();
            }

            $monhoc = MonHoc::find($request->mamonhoc);

            $monhoc->fill($request->toArray());
            $monhoc->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('monhocManage.indexMonHoc');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete($mamonhoc)
    {
        try {
            $monhoc = MonHoc::find($mamonhoc);
            $monhoc->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('monhocManage.indexMonHoc');
        } catch (QueryException $e) {
            // Lỗi dữ liệu được sử dụng (cha-con)
            if ($e->errorInfo[1] == 1451) {
                toastr()->error('Xoá không thành công! Dữ liệu đã được sử dụng!', 'Lỗi!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }
}
