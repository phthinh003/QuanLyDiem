<?php

namespace App\Http\Controllers;

use App\Models\LoaiDiem;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoaiDiemController extends Controller
{
    public function index()
    {
        $page_title = "Loại Điểm";
        $data = LoaiDiem::all();
        confirmDelete("", "");
        return view('pages.danhmuc.loaidiem.indexloaidiem', compact('page_title', 'data'));
    }
    public function create()
    {
        $page_title = "Tạo mới";
        return view('pages.danhmuc.loaidiem.createloaidiem', compact('page_title'));
    }
    public function store(Request $request)
    {
        try {
            // Kiểm tra dữ liệu hợp lệ
            $validator = $this->validation($request);
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $loaidiem = new LoaiDiem();
            $loaidiem->fill($request->toArray());

            $loaidiem->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới loại điểm ' . $loaidiem->tenloaidiem . ' thành công!', 'Thành công!');

            return redirect()->route('loaidiemManage.indexLoaiDiem');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit($id)
    {
        $page_title = "Chỉnh Sửa Thông Tin Loại Điểm";
        $info = LoaiDiem::find($id);
        return view('pages.danhmuc.loaidiem.editloaidiem', compact('page_title', 'info'));
    }

    public function update(Request $request)
    {
        try {
            $validator = $this->validation($request);
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }
            $loaidiem = LoaiDiem::find($request->maloaidiem);

            $loaidiem->fill($request->toArray());
            $loaidiem->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('loaidiemManage.indexLoaiDiem');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete($maloaidiem)
    {
        try {
            $loaidiem = LoaiDiem::find($maloaidiem);
            $loaidiem->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('loaidiemManage.indexLoaiDiem');
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

    // Kiểm tra dữ liệu.
    protected function validation(Request $request)
    {
        try {
            $rules = [
                'tenloaidiem' => 'required',
                'soluong' => 'required',
            ];

            $customMessages = [
                'tenloaidiem.required' => "Tên loại điểm không được trống.",
                'soluong.required' => "Số lượng không được trống",
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
