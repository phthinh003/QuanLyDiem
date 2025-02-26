@extends('layouts.canbo.layoutcanbo')
@section('content')
<div class="mt-2 pt-2 card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h2> Xin chào, {{ $canbo->hoten }}</h2>
        </div>
        <div class="card-toolbar">
        </div>
    </div>
    <div class="card-body">
        <h4>Các lớp chủ nhiệm</h4>
        @foreach ($datalopchunhiem as $item => $value)
        <a href="{{ route('canboManage.danhsachlopchunhiem', ['malop' => $value->malop,'hocky' => 1]) }}">
            <div class="btn btn-success">
                Lớp: {{ $value->tenlop }}
                <hr>
                Niên khóa: {{ $value->tennienkhoa }}
            </div>
        </a>

        @endforeach
        <hr>
        <h4>Các lớp đang dạy</h4>
        @foreach ($datalopday as $item => $value)
        <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $value->mamonhoc,'hocky' => 1]) }}">
            <div class="btn btn-primary">
                Lớp: {{ $value->tenlop }} | Môn: {{ $value->tenmon }}
                <hr>
                Niên khóa: {{ $value->tennienkhoa }}
            </div>
        </a>

        @endforeach
    </div>
</div>
@endsection
