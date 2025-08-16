<?php

namespace App\Http\Controllers;

use App\Models\CanBo;
use App\Models\HocSinh;
use App\Models\PhuHuynh;
use App\Models\ThongBao;
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
        $k10=60;
        $k11=30;
        $k12=10;
        return view('pages.canbo.dashboard',
        compact('page_title','slcanbo','slhocsinh','slphuhuynh','k10','k11','k12','thongbao'));
    }
}
