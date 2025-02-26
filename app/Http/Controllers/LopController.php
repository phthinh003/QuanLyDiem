<?php

namespace App\Http\Controllers;

use App\Models\CanBo;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use App\Models\Lop;
use App\Models\LopHoc;
use App\Models\NienKhoa;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class LopController extends Controller
{
    public function index()
    {
        $page_title = "Lớp";
        $data = Lop::from('lop')
            ->join('nienkhoa', 'nienkhoa.manienkhoa', 'lop.nienkhoa')
            ->join('canbo', 'canbo.macanbo', 'lop.chunhiem')->get();

        confirmDelete("", "");

        // dd(session()->all());
        return view('pages.danhmuc.lop.indexlop', compact('page_title', 'data'));
    }
    public function create()
    {
        $page_title = "Tạo mới";
        $datacanbo = CanBo::where('macanbo', 'LIKE', 'CB%')->get();
        $datanienkhoa = NienKhoa::orderByDesc('manienkhoa')->get();
        return view('pages.danhmuc.lop.createlop', compact('page_title', 'datacanbo', 'datanienkhoa'));
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

            $check_exist = Lop::where(['nienkhoa' => $request->nienkhoa, 'chunhiem' => $request->chunhiem])->get()->first();
            if (!is_null($check_exist)) {
                return redirect()->back()->withErrors(['da_co' => 'Cán bộ đã chủ nhiệm một lớp khác, hãy chọn cán bộ khác!'])->withInput();
            }

            $lop = new Lop();

            $lop->fill($request->toArray());
            $lop->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới lớp ' . $lop->tenlop . ' thành công!', 'Thành công!');

            return redirect()->route('lopManage.indexLop');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit($id)
    {
        $page_title = "Chỉnh Sửa Thông tin Lớp";
        $info = Lop::find($id);
        $datacanbo = CanBo::where('macanbo', 'LIKE', 'CB%')->get();
        $datanienkhoa = NienKhoa::all();
        //du lieu hoc sinh lop hoc
        $data = LopHoc::join('hocsinh', 'lophoc.mahocsinh', 'hocsinh.mahocsinh')
            ->where('malop', $id)->get();

        confirmDelete("", "");
        return view('pages.danhmuc.lop.editlop', compact('page_title', 'info', 'datacanbo', 'datanienkhoa', 'data'));
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

            $check_exist = Lop::where(['nienkhoa' => $request->nienkhoa, 'chunhiem' => $request->chunhiem])->get()->first();
            if (!is_null($check_exist)) {
                return redirect()->back()->withErrors(['da_co' => 'Cán bộ đã chủ nhiệm một lớp khác, hãy chọn cán bộ khác!'])->withInput();
            }

            $lop = Lop::find($request->malop);


            $lop->fill($request->toArray());

            $lop->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('lopManage.indexLop');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete($malop)
    {
        try {
            $lop = Lop::find($malop);
            $lop->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('lopManage.indexLop');
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
    public function editlophoc($malop)
    {
        $page_title = "Lớp Học";
        $lop = Lop::find($malop);

        // Tim hoc sinh da co lop cung nien khoa
        $ds_lop = Lop::select('malop')
            ->where('nienkhoa', $lop->nienkhoa)
            ->get()
            ->toArray(); // Lay danh sach lop cung nien khoa
        $hocsinh_dacolop = LopHoc::select('mahocsinh')->whereIn('malop', $ds_lop)->get()->toArray();

        // Tim hoc sinh chua co lop trong nien khoa
        $data = Hocsinh::whereNotIn('mahocsinh', $hocsinh_dacolop)->get();
        confirmDelete("", "");
        // dd($data);
        return view('pages.danhmuc.lop.editlophoc', compact('page_title', 'data', 'lop'));
    }
    public function storelophoc($mahocsinh, $malop)
    {
        try {

            $hocsinh = HocSinh::find($mahocsinh);
            $lop = Lop::find($malop);

            $lophoc = new LopHoc();
            $lophoc->mahocsinh = $mahocsinh;
            $lophoc->malop = $malop;
            $lophoc->save();


            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm học sinh ' . $hocsinh->hotenhocsinh . ' vào lớp ' . $lop->tenlop . ' thành công!', 'Thành công!');

            return redirect()->route('lophocManage.editLopHoc', ['malop' => $malop]);
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }
    public function deletelophoc($malophoc)
    {
        try {
            $lophoc = LopHoc::find($malophoc);
            $lop = Lop::find($lophoc->malop);
            $lophoc->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('lopManage.editLop', ['malop' => $lop->malop]);
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

    // Check du lieu dau vao
    public function validator(Request $request)
    {
        try {
            $rules = [
                'malop' => 'required',
                'tenlop' => 'required',
            ];

            $customMessages = [
                'malop.required' => "Mã lớp không được để trống.",
                'tenlop.required' => "Tên lớp không được để trống.",
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
