<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CanBo;
use App\Models\HocSinh;
use App\Models\Lop;
use App\Models\LopHoc;
use App\Models\MonHoc;
use App\Models\PhuHuynh;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    // Show form đăng nhập
    public function showFormLogin()
    {
        $page_title = 'Đăng nhập';
        return view('auth.login', compact('page_title'));
    }

    // Xác thực tài khoản
    public function xacthuc(Request $request)
    {
        $validator = $this->validateLogin($request);
        // dd($request);
        // dd($validator);
        if ($validator->fails()) {
            toastr()->error('Đăng nhập không thành công!<br> Chưa nhập tên đăng nhập hoặc mật khẩu!', 'Lỗi!');
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        // Kiểm tra loại tài khoản
        $typeacc = Str::upper(substr($request->username,0,2));
        if ($typeacc=="CB" || Str::upper($request->username)=="ADMIN") {
            $taikhoan = CanBo::find($request->username);
        } else if($typeacc=="HS") {
            $taikhoan = HocSinh::find($request->username);
        } else if($typeacc=="PH") {
            $taikhoan = PhuHuynh::find($request->username);
        } else {
            $taikhoan = null;
        }

        // Kiểm tra tài khoản
        if ($taikhoan != null) {
            if (password_verify($request->password, $taikhoan->matkhau)) {
                $hethong_ngay = date('d', time());
                $hethong_thang = date('m', time());
                $hethong_nam = date('Y', time());

                session()->put("ngayhientai", $hethong_ngay);
                session()->put("thanghientai", $hethong_thang);
                session()->put("namhientai", $hethong_nam);

                // SET thông tin đăng nhập
                session()->put("userid", $request->username);
                if ($typeacc=="CB") {
                    session()->put("userhoten", $taikhoan->hoten);
                    session()->put("type", $taikhoan->loai);
                } else if ($typeacc=="HS") {
                    session()->put("userhoten", $taikhoan->hotenhocsinh);
                } else if ($typeacc=="PH") {
                    session()->put("userhoten", $taikhoan->tenphuhuynh);
                }

                toastr()->success('Đăng nhập thành công!', 'Thành công!');
                if($typeacc=="CB") return redirect()->route('canboManage.indexCanboPage');
                if($typeacc=="HS") return redirect()->route('hocsinhManage.indexHocsinhPage');
                if($typeacc=="PH") return redirect()->route('phuhuynhManage.indexPhuHuynhPage');
                return redirect()->route('dashboard');
            }
        };
        toastr()->error('Tài khoản hoặc mật khẩu không chính xác!', 'Lỗi!');
        return redirect()->back()->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Kiểm tra trạng thái đăng nhập
    public static function checkLogin()
    {
        if (session()->has('userid')) {
            return true;
        } else {
            return false;
        }
    }
    public static function checkLoginAdmin()
    {
        if (session()->has('userid')) {
            $typeacc = Str::upper(substr(session()->get('userid'),0,2));
            if($typeacc=="AD"){
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
    public static function checkLoginCanBo($malop,$mamonhoc,$mahocsinh)
    {
        if (session()->has('userid')) {
            $macanbo=session()->get('userid');
            $typeacc = Str::upper(substr(session()->get('userid'),0,2));
            if($typeacc=="CB"){
                // dd($mamonhoc);
                if($malop==null && $mamonhoc==null && $mahocsinh==null) return true;
                else{
                    $datalopchunhiem = Lop::from('lop')
                                ->where('chunhiem', $macanbo)
                                ->where('malop', $malop)->get();
                    $datalopday = MonHoc::from('monhoc')
                        ->join('lop', 'lop.malop', 'monhoc.malop')
                        ->join('mon', 'monhoc.mamon', 'mon.mamon')
                        ->where('monhoc.macanbo', $macanbo)
                        ->where('monhoc.mamonhoc', $mamonhoc)->get();
                    $diem=Monhoc::join('lop','monhoc.malop','lop.malop')
                            ->join('lophoc','lop.malop','lophoc.malop')
                            ->where('mahocsinh',$mahocsinh)
                            ->where('monhoc.mamonhoc',$mamonhoc)
                            ->where('macanbo',$macanbo)->get();
                    // dd(count($diem));
                    if($mahocsinh!=null && count($diem)==0) return false;

                    if(count($datalopday)==0 && count($datalopchunhiem)==0){
                        return false;
                    }else{
                        return true;
                    }
                }
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
    public static function checkLoginHocSinh($malop)
    {
        if (session()->has('userid')) {
            $mahocsinh=session()->get('userid');
            $typeacc = Str::upper(substr(session()->get('userid'),0,2));
            if($typeacc=="HS"){
                if($malop==null) return true;
                else{
                    $datalop = LopHoc::join('lop', 'lophoc.malop', 'lop.malop')
                        ->where('mahocsinh', $mahocsinh)
                        ->where('lop.malop', $malop)->get();
                    if(count($datalop)==0){
                        return false;
                    }else{
                        return true;
                    }
                }
            }else{
                return false;
            }
        } else {
            return false;
        }
    }
    public static function checkLoginPhuHuynh($mahocsinh, $malop)
    {
        if (session()->has('userid')) {
            $maphuhuynh=session()->get('userid');
            $typeacc = Str::upper(substr(session()->get('userid'),0,2));
            if($typeacc=="PH"){
                if($mahocsinh==null && $malop==null) return true;
                else{
                    $lop=LopHoc::join('hocsinh','hocsinh.mahocsinh','lophoc.mahocsinh')
                            ->where('malop',$malop)
                            ->where('lophoc.mahocsinh',$mahocsinh)
                            ->where('maphuhuynh',$maphuhuynh)->get();
                    if(count($lop)==0)return false;
                    else return true;
                }
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

    // Kiểm tra form dữ liệu
    protected function validateLogin(Request $request)
    {
        try {
            $rules = [
                'username' => 'required|string',
                'password' => 'required|string',
            ];

            $customMessages = [
                'username.required' => "Xin hãy nhập tên đăng nhập",
                'password.required' => "Xin hãy nhập mật khẩu",
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);
            return $validator;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
