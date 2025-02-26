<?php

namespace App\Http\Controllers;

use App\Models\NienKhoa;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class NienKhoaController extends Controller
{
    public function index()
    {
        $page_title = "Niên Khóa";
        $data = NienKhoa::getAllNienKhoa();
        confirmDelete("", "");
        return view('pages.danhmuc.nienkhoa.indexnienkhoa', compact('page_title', 'data'));
    }
    public function create()
    {
        $page_title = "Tạo mới";
        return view('pages.danhmuc.nienkhoa.createnienkhoa', compact('page_title'));
    }
    public function store(Request $request)
    {
        try {
            $nienkhoa = new NienKhoa();
            $nienkhoa->tennienkhoa=$request->tennienkhoa;

            $nienkhoa->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới niên khóa ' . $nienkhoa->tennienkhoa . ' thành công!', 'Thành công!');

            return redirect()->route('nienkhoaManage.indexNienKhoa');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit($id)
    {
        $page_title = "Chỉnh Sửa Thông Tin Niên Khóa";
        $info = NienKhoa::find($id);
        return view('pages.danhmuc.nienkhoa.editnienkhoa', compact('page_title', 'info'));
    }

    public function update(Request $request)
    {
        try {
            $nienkhoa = NienKhoa::find($request->manienkhoa);

            $nienkhoa->tennienkhoa=$request->tennienkhoa;
            $nienkhoa->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('nienkhoaManage.indexNienKhoa');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete($manienkhoa)
    {
        try {
            $nienkhoa = NienKhoa::find($manienkhoa);
            $nienkhoa->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('nienkhoaManage.indexNienKhoa');
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
