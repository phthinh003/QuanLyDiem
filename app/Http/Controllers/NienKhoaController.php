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
            // Kiểm tra dữ liệu
            $validator = $this->validator($request);
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $nienkhoa = new NienKhoa();
            $nienkhoa->tennienkhoa=$request->tennienkhoa;
            $nienkhoa->batdau=$request->batdau;
            $nienkhoa->ketthuc=$request->ketthuc;
            $nienkhoa->hk1=$request->hk1;
            $nienkhoa->hk2=$request->hk2;
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
            $nienkhoa->batdau=$request->batdau;
            $nienkhoa->ketthuc=$request->ketthuc;
            $nienkhoa->hk1=$request->hk1;
            $nienkhoa->hk2=$request->hk2;
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

    public function validator(Request $request) {
        try {
            $rules = [
                'tennienkhoa' => 'required',
                'batdau' => 'required',
                'ketthuc' => 'required',
                'hk1' => 'required',
                'hk2' => 'required',
            ];

            $customMessages = [
                'tennienkhoa.required' => "Tên niên khoá không được để trống.",
                'batdau.required' => "Thời gian bắt đầu không được để trống.",
                'ketthuc.required' => "Thời gian kết thúc không được để trống.",
                'hk1' => "Thời gian kết thúc học kỳ 1 không được để trống",
                'hk2' => "Thời gian kết thúc học kỳ 2 không được để trống"
            ];

            $validator = \Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
