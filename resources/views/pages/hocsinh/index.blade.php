@extends('layouts.hocsinh.layouthocsinh')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h2> Xin chào, {{ $hocsinh->hotenhocsinh }}</h2>
            </div>
            <div class="card-toolbar">
                {{-- <a href="{{ route('canboManage.createCanbo') }}"><button class="btn btn-success">Tạo mới</button></a> --}}
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            @foreach ($datalop as $item => $value)
                <a href="{{ route('hocsinhManage.diemhocsinh', ['malop' => $value->malop,'hocki' => 1]) }}">
                    <div class="btn btn-success">
                        Lớp: {{ $value->tenlop }}
                        <hr>
                        Niên khóa: {{ $value->tennienkhoa }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
