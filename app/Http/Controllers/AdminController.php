<?php

namespace App\Http\Controllers;

use App\Models\CanBo;
use App\Models\HocSinh;
use App\Models\Lop;
use App\Models\LopHoc;
use App\Models\PhuHuynh;
use App\Models\ThongBao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $page_title="Dashboard";
        $slcanbo=CanBo::all()->count();
        $slhocsinh=HocSinh::all()->count();
        $slphuhuynh=PhuHuynh::all()->count();
        $thongbao = ThongBao::where('loainguoinhan', 'giaovien')
            ->orWhere('loainguoinhan', 'all')
            ->orderBy('created_at', 'desc')
            ->get();
        $nowdate=Carbon::now();
        $dslop=Lop::join('nienkhoa','nienkhoa.manienkhoa','lop.nienkhoa')
                    ->where('ketthuc','>',$nowdate)
                    ->select('malop','tenlop')
                    ->get();
        $sllop=count($dslop);

        $k10=0;
        $k11=0;
        $k12=0;
        foreach($dslop as $dsl){
// dd($dsl);
            $lophoc=LopHoc::join('lop','lop.malop','lophoc.malop')
                        ->where('lophoc.malop',$dsl->malop)
                        ->select('malophoc','tenlop')
                        ->get();
// dd($lophoc);
            // dd(substr($dsl->tenlop,0,2));
            $sl=count($lophoc);
            if(substr($dsl->tenlop,0,2)=='10') $k10+=$sl;
            else if(substr($dsl->tenlop,0,2)=='11') $k11+=$sl;
            else if(substr($dsl->tenlop,0,2)=='12') $k12+=$sl;
        }
        // dd($k10,$k11,$k12);
        return view('pages.canbo.dashboard',
        compact('page_title','slcanbo','slhocsinh','slphuhuynh','sllop','k10','k11','k12','thongbao'));
    }
}
