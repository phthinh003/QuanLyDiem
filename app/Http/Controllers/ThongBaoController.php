<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use Illuminate\Http\Request;

class ThongBaoController extends Controller
{
    // Lấy danh sách thông báo theo loại người nhận
    public function index()
    {
        $page_title = "Thông Báo";
        $thongbao = ThongBao::orderBy('created_at', 'desc')
            ->get();
        confirmDelete("", "");

        return view('pages.danhmuc.thongbao.indexthongbao', compact('thongbao', 'page_title'));
    }
    public function loadMore($page, $loainguoinhan)
    {
        $perPage = 3; // số thông báo mỗi lần load
        $thongbao = ThongBao::where('loainguoinhan', $loainguoinhan)
            ->orWhere('loainguoinhan', 'all')
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json($thongbao);
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
        ], [
            'tieude.required' => 'Bạn phải nhập tiêu đề thông báo',
            'tieude.max' => 'Tiêu đề không được quá 255 ký tự',
            'noidung.required' => 'Nội dung không được để trống',
            'loainguoinhan.required' => 'Bạn phải chọn người nhận',
        ]);

        $thongbao = new ThongBao();
        $thongbao->tieude = $request->tieude;
        $thongbao->noidung = $request->noidung;
        if(isset($request->nguoinhan)) $thongbao->nguoinhan=$request->nguoinhan;
        $thongbao->nguoigui = $request->nguoigui;
        $thongbao->loainguoigui = $request->loainguoigui;
        $thongbao->loainguoinhan = $request->loainguoinhan;
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
    public function storeajax(Request $request)
    {
        $tb = ThongBao::create($request->all());
        return response()->json($tb);
    }

    public function update(Request $request, $id)
    {
        $tb = ThongBao::findOrFail($id);
        $tb->update($request->all());
        return response()->json($tb);
    }
}
