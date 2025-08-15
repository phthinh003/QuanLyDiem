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
        $a=60;
        $b=30;
        $c=10;
        return view('pages.canbo.dashboard',
        compact('page_title','slcanbo','slhocsinh','slphuhuynh','a','b','c','thongbao'));
    }
}
