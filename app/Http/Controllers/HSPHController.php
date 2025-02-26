<?php

namespace App\Http\Controllers;

use App\Models\HocSinh;
use App\Models\LopHoc;
use App\Models\PhuHuynh;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class HSPHController extends Controller
{
    public function index_HS()
    {
        $page_title = "Học Sinh";
        $data = HocSinh::getAll();
        // foreach($data as $item=>$value){
        //     print($value);
        //  }
        confirmDelete("", "");

        // dd(session()->all());
        return view('pages.hocsinh_phuhuynh.hocsinh.index', compact('page_title', 'data'));
    }

    public function create_HS()
    {
        $page_title = "Tạo mới - Học sinh";
        return view('pages.hocsinh_phuhuynh.hocsinh.create', compact('page_title'));
    }
    public function store_HS(Request $request)
    {
        try {
            // Kiểm tra dữ liệu hợp lệ
            $validator = $this->validation_hs($request, "them");
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $hocsinh = new HocSinh();
            // if (HocSinh::where('mahocsinh', $request->mahocsinh)->first()) {
            //     return redirect()->back()->withInput();
            // }

            $hocsinh->fill($request->toArray());

            // Khởi tạo mã cán bộ mới
            $hs_lastest = HocSinh::latest('mahocsinh')->select('mahocsinh')->first();
            if ($hs_lastest == null) {
                $mhs_lastest = "HS00001";
            } else {
                $mhs_lastest = $hs_lastest->mahocsinh;
                $mhs_lastest = ((int) substr($mhs_lastest, 2)) + 1;
                $mhs_lastest = "HS" . sprintf("%05d", $mhs_lastest);
            }

            $hocsinh->mahocsinh = $mhs_lastest;
            $hocsinh->matkhau = bcrypt($hocsinh->matkhau);

            $hocsinh->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới thành công!', 'Thành công!');

            return redirect()->route('hocsinhManage.index');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit_HS($id)
    {
        $page_title = "Chỉnh Sửa Thông tin học sinh - MSHS: ".$id;
        $info = HocSinh::find($id);
        if($info->maphuhuynh!=null){
            $phuhuynh=PhuHuynh::find($info->maphuhuynh);
        }else{
            $phuhuynh=null;
        }
        confirmDelete("", "");
        return view('pages.hocsinh_phuhuynh.hocsinh.edit', compact('page_title', 'info','phuhuynh'));
    }

    public function update_HS(Request $request)
    {
        try {
            $validator = $this->validation_hs($request, "sua");
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $hocsinh = HocSinh::find($request->mahocsinh);

            $matkhau = $hocsinh->matkhau;
            $hocsinh->fill($request->toArray());

            // Ma hoa mat khau
            $hocsinh->matkhau = bcrypt($hocsinh->matkhau);

            if ($request->matkhau == "" || $request->matkhau == null) {
                $hocsinh->matkhau = $matkhau;
            }

            $hocsinh->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('hocsinhManage.index');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete_HS($mahocsinh)
    {
        try {
            $hocsinh = HocSinh::find($mahocsinh);
            $hocsinh->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('hocsinhManage.index');
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

    /* -------------------------------------------------------------------- */
    // QUẢN LÝ THÔNG TIN PHỤ HUYNH

    // Show page - Quản lý phụ huynh
    public function index_PH()
    {
        $page_title = "Phụ Huynh - Danh Sách";
        $data = PhuHuynh::getAll();
        // foreach($data as $item=>$value){
        //     print($value);
        //  }
        confirmDelete("", "");
        // dd(session()->all());
        return view('pages.hocsinh_phuhuynh.phuhuynh.index', compact('page_title', 'data'));
    }

    public function create_PH()
    {
        $page_title = "Phụ Huynh - Thêm Mới";
        return view('pages.hocsinh_phuhuynh.phuhuynh.create', compact('page_title'));
    }
    public function store_PH(Request $request)
    {
        try {
            // Kiểm tra dữ liệu
            $validator = $this->validation_ph($request, "them");
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $phuhuynh = new PhuHuynh();
            $phuhuynh->fill($request->toArray());

            // Khởi tạo mã cán bộ mới
            $ph_lastest = PhuHuynh::latest('maphuhuynh')->select('maphuhuynh')->first();
            if ($ph_lastest == null) {
                $mph_lastest = "PH00001";
            } else {
                $mph_lastest = $ph_lastest->maphuhuynh;
                $mph_lastest = ((int) substr($mph_lastest, 2)) + 1;
                $mph_lastest = "PH" . sprintf("%05d", $mph_lastest);
            }

            $phuhuynh->maphuhuynh = $mph_lastest;
            $phuhuynh->matkhau = bcrypt($phuhuynh->matkhau);
            $phuhuynh->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Thêm mới thành công!', 'Thành công!');

            return redirect()->route('phuhuynhManage.index');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function edit_PH($id)
    {
        $page_title = "Phụ huynh - Chỉnh Sửa Thông tin - Mã Số: ".$id;
        $info = PhuHuynh::find($id);
        return view('pages.hocsinh_phuhuynh.phuhuynh.edit', compact('page_title', 'info'));
    }

    public function update_PH(Request $request)
    {
        try {
            // Kiểm tra dữ liệu
            $validator = $this->validation_ph($request, "sua");
            if ($validator->fails()) {
                toastr()->error('Có dữ liệu không hợp lệ!', 'Lỗi!');
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $phuhuynh = PhuHuynh::find($request->maphuhuynh);

            $matkhau = $phuhuynh->matkhau;
            $phuhuynh->fill($request->toArray());
            $phuhuynh->matkhau = bcrypt($phuhuynh->matkhau);
            if ($request->matkhau == "" || $request->matkhau == null) {
                $phuhuynh->matkhau = $matkhau;
            }
            $phuhuynh->save();
            toastr()->success('Cập nhật thông tin thành công!', 'Thành công!');
            return redirect()->route('phuhuynhManage.index');
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function delete_PH($maphuhuynh)
    {
        try {
            $phuhuynh = PhuHuynh::find($maphuhuynh);
            $phuhuynh->delete();
            toastr()->success('Xoá thành công!', 'Thành công!');
            return redirect()->route('phuhuynhManage.index');
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

    public function indexHocSinhPage(){
        $page_title = "Bảng điểm cá nhân";
        $mahocsinh=session('userid');
        $hocsinh=Hocsinh::find($mahocsinh);
        $datalop=LopHoc::join('lop','lophoc.malop','lop.malop')
                        ->join('nienkhoa','lop.nienkhoa','nienkhoa.manienkhoa')
                        ->where('mahocsinh',$mahocsinh)->get();
        return view('pages.hocsinh.index', compact('page_title','datalop','hocsinh'));
    }
    public function indexPhuHuynhPage(){
        $page_title = "Trang chủ";
        //du lieu sidebar
        $maphuhuynh=session('userid');
        $phuhuynh=PhuHuynh::find($maphuhuynh);
        $dshs=HocSinh::where('maphuhuynh',$maphuhuynh)->get();
        $menu=[];
        // dd($dshs);
        foreach($dshs as $key=>$hocsinh){
            $lop=[];
            $lophoc=LopHoc::join('lop','lop.malop','lophoc.malop')
                    ->where('mahocsinh',$hocsinh->mahocsinh)->get();
            foreach($lophoc as $k=>$value){
                $lop=Arr::add($lop,count($lop),[$value]);
            }
            $menu=Arr::add($menu,count($menu),['hocsinh'=>$hocsinh,'lop'=>$lop]);
        }
        // dd($menu);
        // foreach($menu as $item){
        //     foreach($item as $key=>$value){
        //         if($key=='hocsinh'){
        //             print($value.'----------');

        //         }else{
        //             foreach($value as $k=>$v1){
        //                 foreach($v1 as $k1=>$v){
        //                 print($v->malop);
        //                 }
        //             }
        //             print("\n");
        //         }
        //     }
        // }
        // du lieu noi dung
        $datalop=Lophoc::join('lop','lop.malop','lophoc.malop')
                        ->join('hocsinh','lophoc.mahocsinh','hocsinh.mahocsinh')
                        ->join('nienkhoa','lop.nienkhoa','nienkhoa.manienkhoa')
                        ->join('canbo','canbo.macanbo','lop.chunhiem')
                        ->where('maphuhuynh',$maphuhuynh)->get();
        return view('pages.phuhuynh.index', compact('page_title','phuhuynh','menu','datalop'));
    }
    //Lien ket tai khoan
    public function editlk($mahocsinh)
    {
        $page_title = "Chỉnh Sửa Thông tin học sinh - MSHS: ".$mahocsinh;
        $info = HocSinh::find($mahocsinh);
        $data = PhuHuynh::all();
        return view('pages.hocsinh_phuhuynh.hocsinh.lienketphuhuynh', compact('page_title', 'info','data'));
    }
    public function storelk($mahocsinh,$maphuhuynh)
    {
        try {
            $hocsinh = HocSinh::find($mahocsinh);

            $hocsinh->maphuhuynh = $maphuhuynh;
            $hocsinh->save();

            // Hiển thị thông báo thêm thành công
            toastr()->success('Liên kết thành công!', 'Thành công!');

            return redirect()->route('hocsinhManage.edit',['mahocsinh'=>$mahocsinh]);
        } catch (Exception $e) {
            echo 'Có lỗi phát sinh: ', $e->getMessage(), "\n";
        }
    }

    public function deletelk($mahocsinh)
    {
        try {
            $hocsinh = HocSinh::find($mahocsinh);
            $hocsinh->maphuhuynh=null;
            $hocsinh->save();
            // dd($hocsinh);
            toastr()->success('Xoá liên kết thành công!', 'Thành công!');
            return redirect()->route('hocsinhManage.edit',['mahocsinh'=>$mahocsinh]);
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

    // Kiểm tra dữ liệu học sinh.
    protected function validation_hs(Request $request, $type_process)
    {
        try {
            $rules = [
                'hotenhocsinh' => 'required',
                'ngaysinh' => 'required|before:today',
                'diachi' => 'required',
                'sdt' => 'required',
            ];

            $customMessages = [
                'hotenhocsinh.required' => "Họ tên không được để trống.",
                'ngaysinh.required' => "Ngày sinh không được để trống.",
                'ngaysinh.before' => "Ngày sinh phải trước ngày hôm nay.",
                'diachi.required' => "Địa chỉ không được để trống.",
                'sdt.required' => "Số điện thoại không được để trống.",
            ];

            // Them du lieu thi kiem them mat khau
            if ($type_process=="them") {
                $rules += [
                    'matkhau' => 'required'
                ];

                $customMessages += [
                    'matkhau.required' => "Mật khẩu không được để trống",
                ];
            }

            $validator = Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Kiểm tra dữ liệu phụ huynh
    protected function validation_ph(Request $request, $type_process)
    {
        try {
            $rules = [
                'tenphuhuynh' => 'required',
                'ngaysinh' => 'required|before:today',
                'diachi' => 'required',
                'sdt' => 'required',
            ];

            $customMessages = [
                'tenphuhuynh.required' => "Họ tên không được để trống.",
                'ngaysinh.required' => "Ngày sinh không được để trống.",
                'ngaysinh.before' => "Ngày sinh phải trước ngày hôm nay.",
                'diachi.required' => "Địa chỉ không được để trống.",
                'sdt.required' => "Số điện thoại không được để trống.",
            ];

            // Them du lieu thi kiem them mat khau
            if ($type_process=="them") {
                $rules += [
                    'matkhau' => 'required'
                ];

                $customMessages += [
                    'matkhau.required' => "Mật khẩu không được để trống",
                ];
            }

            $validator = Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
