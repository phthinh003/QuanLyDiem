<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use Illuminate\Http\Request;

class ThongBaoController extends Controller
{
    // Lấy danh sách thông báo theo loại người nhận
    public function index($loainguoinhan)
    {
        $thongbao = ThongBao::where('loainguoinhan', $loainguoinhan)
            ->orWhere('loainguoinhan', 'all')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('thongbao.index', compact('thongbao'));
    }

    // Form tạo thông báo
    public function create()
    {
        return view('thongbao.create');
    }

    // Lưu thông báo mới
    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|string|max:255',
            'noidung' => 'required|string',
            'loainguoinhan' => 'required|string',
        ]);

        $thongbao=new ThongBao();
        $thongbao->tieude=$request->tieude;
        $thongbao->noidung=$request->noidung;
        $thongbao->nguoigui=$request->nguoigui;
        $thongbao->loainguoigui=$request->loainguoigui;
        $thongbao->loainguoinhan=$request->loainguoinhan;
        $thongbao->save();

        toastr()->success('Đã gửi thông báo' . ' thành công!', 'Thành công!');

        return redirect()->back();
    }

    // Xem chi tiết thông báo
    public function show($id)
    {
        $thongbao = ThongBao::findOrFail($id);
        return view('thongbao.show', compact('thongbao'));
    }

    // Xóa thông báo
    public function destroy($id)
    {
        ThongBao::destroy($id);
        return redirect()->back()->with('success', 'Đã xóa thông báo');
    }
}
