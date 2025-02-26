<?php

namespace App\Http\Controllers;

use App\Models\Mon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MonController extends Controller
{
    public function index()
    {
        $page_title = "Môn";
        $data = Mon::getAllMon();
        confirmDelete("", "");
        return view('pages.danhmuc.mon.indexmon', compact('page_title', 'data'));
    }
    public function create()
    {
        $page_title = "Tạo mới";
        return view('pages.danhmuc.mon.createmon', compact('page_title'));
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

            $mon = new Mon();
            $mon->fill($request->toArray());

            $mon->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới môn ' . $mon->tenmon . ' thành công!', 'Thành công!');

            return redirect()->route('monManage.indexMon');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit($id)
    {
        $page_title = "Chỉnh Sửa Thông Tin Môn";
        $info = Mon::find($id);
        return view('pages.danhmuc.mon.editmon', compact('page_title', 'info'));
    }

    public function update(Request $request)
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

            $mon = Mon::find($request->mamon);

            $mon->fill($request->toArray());
            $mon->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('monManage.indexMon');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete($mamon)
    {
        try {
            $mon = Mon::find($mamon);
            $mon->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('monManage.indexMon');
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

    public function validator(Request $request)
    {
        try {
            $rules = [
                'mamon' => 'required',
                'tenmon' => 'required',
            ];

            $customMessages = [
                'mamon.required' => "Mã môn không được để trống.",
                'tenmon.required' => "Tên môn không được để trống.",
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
